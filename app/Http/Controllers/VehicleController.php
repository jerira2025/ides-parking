<?php

namespace App\Http\Controllers;
use App\Models\TipoVehiculo;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {  $tipos = TipoVehiculo::all();
        $vehicles = Vehicle::with('owner')->paginate(20);
        return view('vehicles.index', compact('vehicles','tipos'));
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('entries.parkingSpace');
        return view('vehicles.show', compact('vehicle'));
    }

public function store(Request $request)
{
     
     
    $request->validate([
        'plate' => ['required', 'string', 'unique:vehicles', 'regex:/^[A-Z]{3}[0-9]{2}[0-9A-Z]$/'],
        'tipo_vehiculo_id' => 'required|exists:tipo_vehiculos,id',
        'brand' => 'nullable|string|max:50',
        'model' => 'nullable|string|max:50',
        'color' => 'nullable|string|max:30',
        'owner_id' => 'nullable|exists:users,id'
    ]);

    $vehicle = new Vehicle();
    $vehicle->plate = $request->input('plate');
    $vehicle->tipo_vehiculo_id = $request->input('tipo_vehiculo_id');
    $vehicle->brand = $request->input('brand');
    $vehicle->model = $request->input('model');
    $vehicle->color = $request->input('color');
    $vehicle->owner_id = $request->input('owner_id');
    $vehicle->save();

    return response()->json($vehicle, 201);
}

}
