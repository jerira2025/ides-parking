<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espacios_parqueadero;
use App\Models\Zona;
use App\Models\TipoVehiculo;

class EspacioParqueaderoController extends Controller
{
    public function index()
    {
        $espacios = Espacios_parqueadero::with('zona', 'tipoVehiculo')->paginate(10);
        return view('espacios.index', compact('espacios'));
    }

    public function create()
    {
        $zonas = Zona::all();
        $tipos = TipoVehiculo::all();
        return view('espacios.create', compact('zonas', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_espacio' => 'required|unique:espacios_parqueadero',
            'zona_id' => 'required|exists:zonas,id',
            'tipo_vehiculo_id' => 'required|exists:tipo_vehiculos,id',
        ]);

        Espacios_parqueadero::create($request->all());
        return redirect()->route('espacios.index')->with('success', 'Espacio creado correctamente.');
    }

    public function edit(Espacios_parqueadero $espacio)
    {
        $zonas = Zona::all();
        $tipos = TipoVehiculo::all();
        return view('espacios.edit', compact('espacio', 'zonas', 'tipos'));
    }

    public function update(Request $request, Espacios_parqueadero $espacio)
    {
        $request->validate([
            'numero_espacio' => 'required|unique:espacios_parqueadero,numero_espacio,' . $espacio->id,
            'zona_id' => 'required|exists:zonas,id',
            'tipo_vehiculo_id' => 'required|exists:tipo_vehiculos,id',
        ]);

        $espacio->update($request->all());
        return redirect()->route('espacios.index')->with('success', 'Espacio actualizado correctamente.');
    }

    public function destroy(Espacios_parqueadero $espacio)
    {
        $espacio->delete();
        return redirect()->route('espacios.index')->with('success', 'Espacio eliminado.');
    }
}