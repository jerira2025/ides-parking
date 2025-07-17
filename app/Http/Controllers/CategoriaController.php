<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        Categoria::create($request->only('nombre', 'descripcion'));

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id); 

        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $categoria->update($request->only('nombre', 'descripcion'));

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id); // Busca la categoría por ID o lanza 404

        return view('categorias.edit', compact('categoria'));
    }
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.show', compact('categoria'));
    }
}
