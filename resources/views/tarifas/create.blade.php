@extends('layouts.app')

@section('content')
<h2>Crear Tarifa</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('tarifas.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="zona_id" class="form-label">Zona</label>
        <select name="zona_id" id="zona_id" class="form-select" required>
            <option value="">Seleccione una zona</option>
            @foreach($zonas as $zona)
                <option value="{{ $zona->id }}" {{ old('zona_id') == $zona->id ? 'selected' : '' }}>
                    {{ $zona->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="tipo_vehiculo_id" class="form-label">Tipo de Vehículo</label>
        <select name="tipo_vehiculo_id" id="tipo_vehiculo_id" class="form-select" required>
            <option value="">Seleccione tipo</option>
            @foreach($tiposVehiculo as $tipo)
                <option value="{{ $tipo->id }}" {{ old('tipo_vehiculo_id') == $tipo->id ? 'selected' : '' }}>
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="precio_hora" class="form-label">Precio por Hora</label>
        <input type="number" name="precio_hora" step="0.01" class="form-control" value="{{ old('precio_hora') }}">
    </div>

    <div class="mb-3">
        <label for="precio_dia" class="form-label">Precio por Día</label>
        <input type="number" name="precio_dia" step="0.01" class="form-control" value="{{ old('precio_dia') }}">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('tarifas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
