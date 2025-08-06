@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Espacio de Parqueadero</h1>

    <form action="{{ route('espacios.update', $espacio->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="numero_espacio" class="form-label">Número de Espacio</label>
            <input type="text" name="numero_espacio" id="numero_espacio" class="form-control"
                value="{{ old('numero_espacio', $espacio->numero_espacio) }}" required>
        </div>

        <div class="mb-3">
            <label for="zona_id" class="form-label">Zona</label>
            <select name="zona_id" id="zona_id" class="form-select" required>
                <option value="">Seleccione tipo de zona</option>
                @foreach($zonas as $zona)
                    <option value="{{ $zona->id }}" {{ $zona->id == $espacio->zona_id ? 'selected' : '' }}>
                        {{ $zona->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo_vehiculo_id" class="form-label">Tipo de Vehículo</label>
            <select name="tipo_vehiculo_id" id="tipo_vehiculo_id" class="form-select" required>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ $tipo->id == $espacio->tipo_vehiculo_id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('espacios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
