<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\Compatibilidades;
use App\Models\Espacios_parqueadero;
use App\Models\TipoVehiculo;

class VehicleEntryController extends Controller
{
    public function index()
    {
        $activeEntries = VehicleEntry::with(['vehicle.tipoVehiculo', 'espacio.zona'])
            ->whereNull('exit_time')
            ->latest('entry_time')
            ->get();

        $ocupados = VehicleEntry::whereNull('exit_time')->pluck('espacio_id');
        $availableSpaces = Espacios_parqueadero::whereNotIn('id', $ocupados)->count();
        $espaciosDisponibles = Espacios_parqueadero::whereNotIn('id', $ocupados)->with('zona')->get();

        $totalSpaces = Espacios_parqueadero::count();
        $tipos = TipoVehiculo::all();

        return view('parking.dashboard', compact('activeEntries', 'availableSpaces', 'totalSpaces', 'tipos', 'espaciosDisponibles'));
    }

    public function registerEntry(Request $request)
    {
        $request->validate([
            'plate' => ['required', 'string', 'regex:/^[A-Z]{3}[0-9]{2}[0-9A-Z]$/'],
            'tipo_vehiculo_id' => 'required|exists:tipo_vehiculos,id',
            'brand' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:30'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $plate = strtoupper($request->plate);

                // Buscar o crear vehículo
                $vehicle = Vehicle::firstOrCreate(
                    ['plate' => $plate],
                    [
                        'tipo_vehiculo_id' => $request->tipo_vehiculo_id,
                        'brand' => $request->brand,
                        'model' => $request->model,
                        'color' => $request->color
                    ]
                );

                // Verificar si ya está estacionado
                if ($vehicle->isParked()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El vehículo ya se encuentra estacionado'
                    ], 400);
                }

                // Buscar espacio compatible
                $tipo = TipoVehiculo::find($request->tipo_vehiculo_id);
                $zonasCompatibles = Compatibilidades::where('tipo_vehiculo_id', $tipo->id)->pluck('zona_id');
                $espaciosOcupados = VehicleEntry::whereNull('exit_time')->pluck('espacio_id');

                $espacio = Espacios_parqueadero::whereNotIn('id', $espaciosOcupados)
                    ->whereIn('zona_id', $zonasCompatibles)
                    ->first();

                if (!$espacio) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No hay espacios disponibles para este tipo de vehículo'
                    ], 400);
                }

                // Crear entrada
                $entry = VehicleEntry::create([
                    'vehicle_id' => $vehicle->id,
                    'espacio_id' => $espacio->id,
                    'entry_time' => Carbon::now(),
                    'ticket_code' => (string) Str::uuid(),
                ]);

                if (!$entry) {
                    throw new \Exception("No se pudo crear el registro de entrada.");
                }

                // Generar QR
                $qr = base64_encode(QrCode::format('png')->size(150)->generate($entry->ticket_code));
                $ticketHtml = view('parking.ticket', ['entrada' => $entry, 'qr' => $qr])->render();

                return response()->json([
    'success' => true,
    'message' => 'Entrada registrada exitosamente',
    'data' => [
        'vehicle' => $vehicle,
        'parking_space' => $espacio,
        'entry' => $entry,
        'ticket_html' => $ticketHtml, // Aquí mandamos el HTML del ticket
    ]
]);
            });
        } catch (\Exception $e) {
            Log::error("Error al registrar entrada: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar entrada: ' . $e->getMessage()
            ], 500);
        }
    }

    public function registerExit(Request $request)
    {
        $request->validate([
            'plate' => ['required', 'string', 'regex:/^[A-Z]{3}[0-9]{2}[0-9A-Z]$/']
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $plate = strtoupper($request->plate);
                $vehicle = Vehicle::where('plate', $plate)->first();

                if (!$vehicle) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vehículo no encontrado'
                    ], 404);
                }

                $entry = $vehicle->getCurrentEntry();

                if (!$entry) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El vehículo no se encuentra estacionado'
                    ], 400);
                }

                $exitTime = Carbon::now();
                $entry->update(['exit_time' => $exitTime]);
                $duration = $entry->entry_time->diffInMinutes($exitTime);

                return response()->json([
                    'success' => true,
                    'message' => 'Salida registrada exitosamente',
                    'data' => [
                        'vehicle' => $vehicle,
                        'entry_time' => $entry->entry_time,
                        'exit_time' => $exitTime,
                        'duration_minutes' => $duration,
                        'parking_space' => $entry->espacio
                    ]
                ]);
            });
        } catch (\Exception $e) {
            Log::error("Error al registrar salida: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar salida: ' . $e->getMessage()
            ], 500);
        }
    }

    public function history()
    {
        $entries = VehicleEntry::with(['vehicle.tipoVehiculo', 'espacio.zona'])
            ->orderBy('entry_time', 'desc')
            ->paginate(20);

        return view('parking.history', compact('entries'));
    }

    public function espaciosDisponibles($tipoVehiculoId)
    {
        $espacios = DB::table('espacios_parqueadero')
            ->join('compatibilidades', 'espacios_parqueadero.zona_id', '=', 'compatibilidades.zona_id')
            ->join('zonas', 'espacios_parqueadero.zona_id', '=', 'zonas.id')
            ->leftJoin('vehicle_entries', function ($join) {
                $join->on('espacios_parqueadero.id', '=', 'vehicle_entries.espacio_id')
                    ->whereNull('vehicle_entries.exit_time');
            })
            ->where('compatibilidades.tipo_vehiculo_id', $tipoVehiculoId)
            ->whereNull('vehicle_entries.id')
            ->select('espacios_parqueadero.id', 'espacios_parqueadero.numero_espacio as numero', 'zonas.nombre as zona')
            ->get();

        return response()->json($espacios);
    }

    public function estadoEspacios()
    {
        $espacios = Espacios_parqueadero::with('zona')->get();
        return view('parking.spaces', compact('espacios'));
    }

    public function invoiceHtml($id)
    {
        $entry = VehicleEntry::with(['vehicle.tipoVehiculo', 'espacio.zona'])->findOrFail($id);
        return view('parking.invoice-html', compact('entry'));
    }
}
