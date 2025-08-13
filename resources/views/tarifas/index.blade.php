@extends('layouts.app')

@section('content')
<h1>Tarifas por Zona y Tipo de Vehículo</h1>

<a href="{{ route('tarifas.create') }}" class="btn btn-primary mb-3">Crear nueva tarifa</a>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>Zona</th>
            <th>Tipo de Vehículo</th>
            <th>Precio por Hora</th>
            <th>Precio por Día</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tarifas as $tarifa)
        <tr>
            <td>{{ $tarifa->zona->nombre }}</td>
            <td>{{ $tarifa->tipoVehiculo->nombre }}</td>
            <td>${{ number_format($tarifa->precio_hora, 0) }}</td>
            <td>${{ number_format($tarifa->precio_dia, 0) }}</td>
            <td>
                <a href="{{ route('tarifas.edit', $tarifa) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('tarifas.destroy', $tarifa) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta tarifa?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $tarifas->links() }}
@endsection
