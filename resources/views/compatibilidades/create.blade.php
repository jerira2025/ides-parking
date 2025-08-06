@extends('layouts.app')

@section('content')
<h1>Nueva Compatibilidad</h1>

@if($errors->has('duplicado'))
    <div class="alert alert-danger">
        {{ $errors->first('duplicado') }}
    </div>
@endif

<form action="{{ route('compatibilidades.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="zona_id" class="form-label">Zona</label>
        <select name="zona_id" class="form-select" required>
            <option value="">Seleccione una zona</option>
            @foreach($zonas as $zona)
                <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="tipo_vehiculo_id" class="form-label">Tipo de Vehículo</label>
        <select name="tipo_vehiculo_id" class="form-select" required>
            <option value="">Seleccione un tipo</option>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('compatibilidades.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
