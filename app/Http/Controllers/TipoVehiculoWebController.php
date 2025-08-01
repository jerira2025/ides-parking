<?php

namespace App\Http\Controllers;

use App\Models\TipoVehiculo;
use Illuminate\Http\Request;

class TipoVehiculoWebController extends Controller
{
    public function index()
    {
        $tipos = TipoVehiculo::all();
        return view('tipo_vehiculos.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipo_vehiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:3|unique:tipo_vehiculos,codigo',
            'nombre' => 'required|string|max:100',
        ]);

        TipoVehiculo::create([
            'codigo' => strtoupper($request->codigo),
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipo_vehiculos.index')->with('success', 'Tipo de vehículo creado correctamente.');
    }

    public function edit($id)
    {
        $tipo = TipoVehiculo::findOrFail($id);
        return view('tipo_vehiculos.edit', compact('tipo'));
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoVehiculo::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|max:3|unique:tipo_vehiculos,codigo,' . $tipo->id,
            'nombre' => 'required|string|max:100',
        ]);

        $tipo->update([
            'codigo' => strtoupper($request->codigo),
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipo_vehiculos.index')->with('success', 'Tipo de vehículo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $tipo = TipoVehiculo::findOrFail($id);
        $tipo->delete();

        return redirect()->route('tipo_vehiculos.index')->with('success', 'Tipo de vehículo eliminado.');
    }
}
