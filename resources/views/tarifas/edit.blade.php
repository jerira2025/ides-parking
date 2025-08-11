@extends('layouts.app')

@section('content')
<h2>Editar Tarifa</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('tarifas.update', $tarifa) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="zona_id" class="form-label">Zona</label>
        <select name="zona_id" class="form-select" required>
            @foreach($zonas as $zona)
                <option value="{{ $zona->id }}" {{ $zona->id == $tarifa->zona_id ? 'selected' : '' }}>
                    {{ $zona->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="tipo_vehiculo_id" class="form-label">Tipo de Vehículo</label>
        <select name="tipo_vehiculo_id" class="form-select" required>
            @foreach($tiposVehiculo as $tipo)
                <option value="{{ $tipo->id }}" {{ $tipo->id == $tarifa->tipo_vehiculo_id ? 'selected' : '' }}>
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
    </div>


        <div class="mb-3">
        <label for="precio_hora" class="form-label">Precio por Hora</label>
        <input type="text"
            name="precio_hora"
            class="form-control"
            value="{{ $tarifa->precio_hora }}"
            oninput="formatearMoneda(this)">
    </div>

    <div class="mb-3">
        <label for="precio_dia" class="form-label">Precio por Día</label>
        <input type="text"
            name="precio_dia"
            class="form-control"
            value="{{ $tarifa->precio_dia }}"
            oninput="formatearMoneda(this)">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('tarifas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection

<script>
    function formatearMoneda(input) {

        let valor = input.value.replace(/\D/g, '');


        if (valor === '') {
            input.value = '';
            return;
        }


        let opciones = {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        };
        let valorFormateado = (parseInt(valor) / 100).toLocaleString('es-CO', opciones);

        input.value = valorFormateado;
    }
</script>
