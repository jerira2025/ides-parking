@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Zona</h1>

    <form action="{{ route('zonas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Zona</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
                value="{{ old('nombre') }}" placeholder="Nombre" required>
        </div>

        <!-- <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción">{{ old('descripcion') }}</textarea>
        </div> -->

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('zonas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
