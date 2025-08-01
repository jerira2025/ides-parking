@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Tipo de Vehículo</h1>

    <form action="{{ route('tipo_vehiculos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" class="form-control" name="codigo" maxlength="3" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" maxlength="100" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('tipo_vehiculos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
