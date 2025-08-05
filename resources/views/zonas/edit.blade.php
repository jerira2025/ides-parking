@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Zona</h1>

    <form action="{{ route('zonas.update', $zona) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Zona</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
                value="{{ old('nombre', $zona->nombre) }}" required>
        </div>

        <!-- <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $zona->descripcion) }}</textarea>
        </div> -->



        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('zonas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection