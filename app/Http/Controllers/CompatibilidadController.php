<?php

namespace App\Http\Controllers;

use App\Models\Compatibilidades;
use App\Models\Zona;
use App\Models\TipoVehiculo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompatibilidadController extends Controller
{
    public function index()
    {
        $compatibilidades = Compatibilidades::with(['zona', 'tipoVehiculo'])->paginate(10);
        $zonas = Zona::all();
        return view('compatibilidades.index', compact('compatibilidades', 'zonas'));
    }

    public function create()
    {
        $zonas = Zona::all();
        $tipos = TipoVehiculo::all();
        return view('compatibilidades.create', compact('zonas', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zona_id' => 'required|exists:zonas,id',
            'tipo_vehiculo_id' => 'required|exists:tipo_vehiculos,id',
        ]);

        $existe = Compatibilidades::where('zona_id', $request->zona_id)
            ->where('tipo_vehiculo_id', $request->tipo_vehiculo_id)
            ->exists();

        if ($existe) {
            return back()->withInput()->withErrors([
                'duplicado' => 'Ya existe esta compatibilidad.',
            ]);
        }

        Compatibilidades::create($request->only('zona_id', 'tipo_vehiculo_id'));

        return redirect()->route('compatibilidades.index')->with('success', 'Compatibilidad creada');
    }

    public function edit(Compatibilidades $compatibilidad)
    {
        $zonas = Zona::all();
        $tipos = TipoVehiculo::all();

        return view('compatibilidades.edit', compact('compatibilidad', 'zonas', 'tipos'));
    }


    public function update(Request $request, Compatibilidades $compatibilidad)
    {
        $request->validate([
            'zona_id' => 'required|exists:zonas,id',
            'tipo_vehiculo_id' => [
                'required',
                'exists:tipo_vehiculos,id',
                Rule::unique('compatibilidades')
                    ->where(function ($query) use ($request) {
                        return $query->where('zona_id', $request->zona_id);
                    })
                    ->ignore($compatibilidad->id),
            ],
        ]);

        $compatibilidad->update($request->only('zona_id', 'tipo_vehiculo_id'));

        return redirect()->route('compatibilidades.index')
            ->with('success', 'Compatibilidad actualizada correctamente.');
    }


    public function destroy(Compatibilidades $compatibilidad)
    {
        $compatibilidad->delete();
        return redirect()->route('compatibilidades.index')->with('success', 'Compatibilidad eliminada');
    }
}
