<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use App\Models\Zona;
use App\Models\TipoVehiculo;
use Illuminate\Http\Request;

class TarifaController extends Controller
{
    public function index()
    {
        $tarifas = Tarifa::with(['zona', 'tipoVehiculo'])->paginate(10);
        return view('tarifas.index', compact('tarifas'));
    }

    public function create()
    {
        $zonas = Zona::all();
        $tiposVehiculo = TipoVehiculo::all();
        return view('tarifas.create', compact('zonas', 'tiposVehiculo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zona_id' => 'required|exists:zonas,id',
            'tipo_vehiculo_id' => 'required|exists:tipo_vehiculos,id',
            'precio_hora' => 'nullable|numeric|min:0',
            'precio_dia' => 'nullable|numeric|min:0',
        ]);

        $existe = Tarifa::where('zona_id', $request->zona_id)
            ->where('tipo_vehiculo_id', $request->tipo_vehiculo_id)
            ->exists();

        if ($existe) {
            return back()->withErrors(['duplicado' => 'Ya existe esta tarifa.'])->withInput();
        }

        Tarifa::create($request->only(['zona_id', 'tipo_vehiculo_id', 'precio_hora', 'precio_dia']));

        return redirect()->route('tarifas.index')->with('success', 'Tarifa creada correctamente.');
    }

    public function edit(Tarifa $tarifa)
    {
        $zonas = Zona::all();
        $tiposVehiculo = TipoVehiculo::all();
        return view('tarifas.edit', compact('tarifa', 'zonas', 'tiposVehiculo'));
    }

    public function update(Request $request, Tarifa $tarifa)
    {
        $request->validate([
            'zona_id' => 'required|exists:zonas,id',
            'tipo_vehiculo_id' => 'required|exists:tipo_vehiculos,id',
            'precio_hora' => 'nullable|numeric|min:0',
            'precio_dia' => 'nullable|numeric|min:0',
        ]);

        $tarifa->update($request->only(['zona_id', 'tipo_vehiculo_id', 'precio_hora', 'precio_dia']));

        return redirect()->route('tarifas.index')->with('success', 'Tarifa actualizada.');
    }

    public function destroy(Tarifa $tarifa)
    {
        $tarifa->delete();
        return redirect()->route('tarifas.index')->with('success', 'Tarifa eliminada.');
    }
}
