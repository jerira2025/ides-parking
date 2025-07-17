@extends('layouts.app')

@section('content')
<div class="container">
    <h2>✏️ Editar Categoría</h2>

    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="{{ $categoria->nombre }}" required>
        </div>

        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control">{{ $categoria->descripcion }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Actualizar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary mt-2">Cancelar</a>
    </form>
</div>
@endsection
