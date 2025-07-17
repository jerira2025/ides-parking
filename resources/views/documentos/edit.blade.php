@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Documento</h2>

    <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Título:</label>
            <input type="text" name="titulo" value="{{ $documento->titulo }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control">{{ $documento->descripcion }}</textarea>
        </div>

        <div class="form-group">
            <label>Tipo de Documento:</label>
            <select name="tipo_documento_id" class="form-control" required>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ $documento->tipo_documento_id == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Categoría:</label>
            <select name="categoria_id" class="form-control" required>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $documento->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Archivo (opcional para reemplazar):</label>
            <input type="file" name="archivo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
