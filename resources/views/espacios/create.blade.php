@extends('layouts.app')

@section('content')
<h1>Crear Espacio de Parqueadero</h1>

<form action="{{ route('espacios.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Número de Espacio</label>
        <input type="text" name="numero_espacio" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Zona</label>
        <select name="zona_id" class="form-select" required>
            <option value="">Seleccione tipo de zona</option>
            @foreach($zonas as $zona)
                <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Tipo de Vehículo</label>
        <select name="tipo_vehiculo_id" class="form-select" required>
            <option value="">Seleccione tipo de vehículo</option>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('espacios.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
