@extends('layouts.app')

@section('title', 'Editar Compatibilidad')

@section('content')
    <div class="container">
        <h1>Editar Compatibilidad</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <form action="{{ route('compatibilidades.update', $compatibilidad->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="zona_id" class="form-label">Zona</label>
                <select name="zona_id" id="zona_id" class="form-select" required>
                    <option value="">Selecciona una zona</option>
                    @foreach ($zonas as $zona)
                        <option value="{{ $zona->id }}" 
                            {{ $zona->id == old('zona_id', $compatibilidad->zona_id) ? 'selected' : '' }}>
                            {{ $zona->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tipo_vehiculo_id" class="form-label">Tipo de Vehículo</label>
                <select name="tipo_vehiculo_id" id="tipo_vehiculo_id" class="form-select" required>
                    <option value="">Selecciona un tipo</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}"
                            {{ $tipo->id == old('tipo_vehiculo_id', $compatibilidad->tipo_vehiculo_id) ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <a href="{{ route('compatibilidades.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
@endsection
