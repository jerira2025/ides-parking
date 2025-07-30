<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('owner')->paginate(20);
        return view('vehicles.index', compact('vehicles'));
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
            'type' => 'required|in:car,motorcycle,truck,bus,other',
            'brand' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:30',
            'owner_id' => 'nullable|exists:users,id'
        ]);

        $vehicle = Vehicle::create($request->all());
        
        return response()->json($vehicle, 201);
    }
}