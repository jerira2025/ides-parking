@extends('layouts.app')

@section('content')
<div class="container">
    <h2>➕ Nueva Categoría</h2>

    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-2">Guardar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary mt-2">Cancelar</a>
    </form>
</div>
@endsection
