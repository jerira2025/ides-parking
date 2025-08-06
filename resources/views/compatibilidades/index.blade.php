@extends('layouts.app')

@section('content')
<h1>Compatibilidades entre Zonas y Tipos de Vehículo</h1>
<a href="{{ route('compatibilidades.create') }}" class="btn btn-primary">Crear nueva compatibilidad</a>

@if(session('success'))
<div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Zona</th>
            <th>Tipo de Vehículo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($compatibilidades as $compatibilidad)
        <tr>
            <td>{{ $compatibilidad->zona->nombre }}</td>
            <td>{{ $compatibilidad->tipoVehiculo->nombre }}</td>
            <td>
                <a href="{{ route('compatibilidades.edit', $compatibilidad->id) }}"class="btn btn-sm btn-warning">Editar</a>

                <form action="{{ route('compatibilidades.destroy', $compatibilidad->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $compatibilidades->links() }}
@endsection