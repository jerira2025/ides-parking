<?php

namespace App\Http\Controllers;

use App\Models\ParkingSpace;
use Illuminate\Http\Request;

class ParkingSpaceController extends Controller
{
    public function index()
    {
        $spaces = ParkingSpace::with('getCurrentEntry.vehicle')->get();
        return view('parking.spaces', compact('spaces'));
    }

    public function show(ParkingSpace $parkingSpace)
    {
        $parkingSpace->load('entries.vehicle');
        return view('parking.space-detail', compact('parkingSpace'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zone' => 'nullable|string|max:10'
        ]);

        $space = ParkingSpace::create($request->all());
        
        return response()->json($space, 201);
    }
}