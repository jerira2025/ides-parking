@extends('layouts.app')

@section('title', 'Zonas del Parqueadero')

@section('content')
<div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-layer-group me-2"></i>Zonas</h1>
        <a href="{{ route('zonas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Crear nueva zona
        </a>
    </div>
</div>

@if($zonas->count() > 0)
<div class="row">
    @foreach ($zonas as $zona)
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $zona->nombre }}</h5>
                <p class="card-text text-muted">ID: {{ $zona->id }}</p>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('zonas.edit', $zona) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('zonas.destroy', $zona) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="alert alert-info">
    No hay zonas registradas aún.
</div>
@endif
@endsection
