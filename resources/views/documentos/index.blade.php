@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📄 Listado de Documentos</h2>

    <!-- Botón "Nuevo Documento" estilizado y alineado a la derecha -->
    <div class="d-flex justify-content-start mb-3">
        <a href="{{ route('documentos.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="fa fa-plus me-2"></i> Nuevo Documento
        </a>
    </div>

    <!-- Formulario de filtros -->
    <form method="GET" action="{{ route('documentos.index') }}" class="mb-4 row g-2">
        <div class="col-md-4">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar por título..." value="{{ request('buscar') }}">
        </div>
        <div class="col-md-3">
            <select name="categoria_id" class="form-control">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="tipo_documento_id" class="form-control">
                <option value="">Todos los tipos</option>
                @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}" {{ request('tipo_documento_id') == $tipo->id ? 'selected' : '' }}>
                    {{ $tipo->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <!-- Tabla de documentos -->
    <table class="table table-bordered table-hover align-middle" style="min-width: 1000px;">
        <thead class="table-light">
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Archivo</th>
                <th style="width: 150px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentos as $doc)
            <tr>
                <td>{{ $doc->titulo }}</td>
                <td>{{ $doc->categoria->nombre }}</td>
               <td>{{ $doc->tipoDocumento->nombre ?? 'Sin tipo' }}</td>
                <td>{{ $doc->fecha_documento }}</td>
                <td>
                    <a href="{{ route('documentos.descargar', $doc->id) }}" class="btn btn-sm btn-success">
                        Descargar
                    </a>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('documentos.show', $doc->id) }}" class="btn btn-sm btn-info" title="Ver">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('documentos.edit', $doc->id) }}" class="btn btn-sm btn-warning" title="Editar">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este documento?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6">No hay documentos disponibles.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $documentos->links() }}
    </div>
</div>
@endsection