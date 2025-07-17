@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>📁 Categorías</h2>

    <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Nueva Categoría</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover table-striped w-100">
        <thead class="table-light">
            <tr>
                <th style="width: 25%;">Nombre</th>
                <th style="width: 45%;">Descripción</th>
                <th style="width: 30%;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
            <tr>
                <td>{{ $categoria->nombre }}</td>
                <td>{{ $categoria->descripcion }}</td>
                <td>
                    {{-- <a href="{{ route('categorias.show', $categoria->id) }}" class="btn btn-sm btn-info" title="Ver">
                    <i class="fa fa-eye"></i>
                    </a>--}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-sm btn-warning" title="Editar">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta categoría?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection