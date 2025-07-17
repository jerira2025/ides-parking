@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">📄 Tipos de Documentos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('tipo_documentos.create') }}" class="btn btn-primary mb-3">
        <i class="fa fa-plus"></i> Nuevo Tipo
    </a>

    <table class="table table-bordered table-hover table-striped w-100">
        <thead class="table-light">
            <tr>
                <th style="width: 70%;">Nombre</th>
                <th style="width: 30%;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->nombre }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('tipo_documentos.edit', $tipo->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('tipo_documentos.destroy', $tipo->id) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este tipo de documento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">No hay tipos de documentos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
