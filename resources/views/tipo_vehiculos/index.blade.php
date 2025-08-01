@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tipos de Vehículos</h1>
    <a href="{{ route('tipo_vehiculos.create') }}" class="btn btn-primary mb-3">Agregar Tipo de Vehículo</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->codigo }}</td>
                    <td>{{ $tipo->nombre }}</td>
                    <td>
                        <a href="{{ route('tipo_vehiculos.edit', $tipo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('tipo_vehiculos.destroy', $tipo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este tipo?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
