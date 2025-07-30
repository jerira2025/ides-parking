<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\ParkingSpace;
use App\Models\VehicleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehicleEntryController extends Controller
{
    public function index()
    {
        $activeEntries = VehicleEntry::with(['vehicle', 'parkingSpace'])
            ->whereNull('exit_time')
            ->latest('entry_time')
            ->get();
            
        $availableSpaces = ParkingSpace::where('is_available', true)->count();
        $totalSpaces = ParkingSpace::count();
        
        return view('parking.dashboard', compact('activeEntries', 'availableSpaces', 'totalSpaces'));
    }

    public function registerEntry(Request $request)
    {
        $request->validate([
            'plate' => ['required', 'string', 'regex:/^[A-Z]{3}[0-9]{2}[0-9A-Z]$/'],
            'type' => 'nullable|in:car,motorcycle,truck,bus,other',
            'brand' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:30'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $plate = strtoupper($request->plate);
                
                // Buscar o crear vehículo
                $vehicle = Vehicle::where('plate', $plate)->first();
                
                if (!$vehicle) {
                    $vehicle = Vehicle::create([
                        'plate' => $plate,
                        'type' => $request->type ?? 'car',
                        'brand' => $request->brand,
                        'model' => $request->model,
                        'color' => $request->color
                    ]);
                }

                // Verificar si el vehículo ya está estacionado
                if ($vehicle->isParked()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El vehículo ya se encuentra estacionado'
                    ], 400);
                }

                // Buscar espacio disponible
                $parkingSpace = ParkingSpace::where('is_available', true)->first();
                
                if (!$parkingSpace) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No hay espacios disponibles'
                    ], 400);
                }

                // Crear entrada
                $entry = VehicleEntry::create([
                    'vehicle_id' => $vehicle->id,
                    'parking_space_id' => $parkingSpace->id,
                    'entry_time' => Carbon::now()
                ]);

                // Marcar espacio como ocupado
                $parkingSpace->update(['is_available' => false]);

                return response()->json([
                    'success' => true,
                    'message' => 'Entrada registrada exitosamente',
                    'data' => [
                        'vehicle' => $vehicle,
                        'parking_space' => $parkingSpace,
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

                // Liberar espacio
                if ($entry->parkingSpace) {
                    $entry->parkingSpace->update(['is_available' => true]);
                }

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
        $entries = VehicleEntry::with(['vehicle', 'parkingSpace'])
            ->orderBy('entry_time', 'desc')
            ->paginate(20);
            
        return view('parking.history', compact('entries'));
    }
}
