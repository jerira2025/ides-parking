<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDocumento;

class TipoDocumentoController extends Controller
{
    // Mostrar listado
    public function index()
    {
        $tipos = TipoDocumento::all();
        return view('tipo_documentos.index', compact('tipos'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('tipo_documentos.create');
    }

    // Guardar nuevo tipo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipos_documento,nombre',
        ]);

        TipoDocumento::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipo_documentos.index')
            ->with('success', 'Tipo de documento creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $tipo = TipoDocumento::findOrFail($id);
        return view('tipo_documentos.edit', compact('tipo'));
    }

    // Actualizar tipo existente
    public function update(Request $request, $id)
    {
        $tipo = TipoDocumento::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_documentos,nombre,' . $tipo->id,
        ]);

        $tipo->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipo_documentos.index')
            ->with('success', 'Tipo de documento actualizado correctamente.');
    }

    // Eliminar tipo
    public function destroy($id)
    {
        $tipo = TipoDocumento::findOrFail($id);
        $tipo->delete();

        return redirect()->route('tipo_documentos.index')
            ->with('success', 'Tipo de documento eliminado correctamente.');
    }
}
