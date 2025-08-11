<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Compatibilidades;
use App\Models\Zona; 
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

        // NUEVA LÓGICA DE ESPACIOS DISPONIBLES
        $ocupados = VehicleEntry::whereNull('exit_time')->pluck('espacio_id');
        $availableSpaces = Espacios_parqueadero::whereNotIn('id', $ocupados)->count();

        $totalSpaces = Espacios_parqueadero::count();
        $tipos = TipoVehiculo::all();
        return view('parking.dashboard', compact('activeEntries', 'availableSpaces', 'totalSpaces', 'tipos',));
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


                // Verificar si el vehículo ya está estacionado
                if ($vehicle->isParked()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El vehículo ya se encuentra estacionado'
                    ], 400);
                }

                // Buscar espacio disponible
                $tipo = TipoVehiculo::find($request->tipo_vehiculo_id);

                if (!$tipo) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tipo de vehículo no reconocido'
                    ], 400);
                }

                // Buscar zonas compatibles
                $zonasCompatibles = Compatibilidades::where('tipo_vehiculo_id', $tipo->id)->pluck('zona_id');

                // Buscar espacio disponible en zonas compatibles
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
                    'entry_time' => Carbon::now()
                ]);

                // Marcar espacio como ocupado
                // $espacio->update(['estado' => 'ocupado']);

                return response()->json([
                    'success' => true,
                    'message' => 'Entrada registrada exitosamente',
                    'data' => [
                        'vehicle' => $vehicle,
                        'parking_space' => $espacio,
                        'entry' => $entry
                    ]
                ]);
            });
        } catch (\Exception $e) {
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

                // Buscar vehículo
                $vehicle = Vehicle::where('plate', $plate)->first();

                if (!$vehicle) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vehículo no encontrado'
                    ], 404);
                }

                // Buscar entrada activa
                $entry = $vehicle->getCurrentEntry();

                if (!$entry) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El vehículo no se encuentra estacionado'
                    ], 400);
                }

                $exitTime = Carbon::now();

                // Registrar salida
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
                        'parking_space' => $entry->parkingSpace
                    ]
                ]);
            });
        } catch (\Exception $e) {
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
}
