{{-- resources/views/parking/spaces.blade.php --}}
@extends('layouts.app')

@section('title', 'Espacios de Parqueo')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">
            <i class="fas fa-parking me-2"></i>Espacios de Parqueo
        </h1>
    </div>
</div>

<div class="row">
    @foreach($spaces->groupBy('zone') as $zone => $zoneSpaces)
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    Zona {{ $zone ?? 'Sin Zona' }} 
                    <span class="badge bg-secondary ms-2">{{ $zoneSpaces->count() }} espacios</span>
                    <span class="badge bg-success ms-1">{{ $zoneSpaces->where('is_available', true)->count() }} disponibles</span>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($zoneSpaces as $space)
                    <div class="col-md-2 col-sm-3 col-4 mb-3">
                        <div class="card text-center {{ $space->is_available ? 'space-available' : 'space-occupied' }}">
                            <div class="card-body py-2">
                                <h6 class="card-title mb-1">#{{ $space->id }}</h6>
                                @if(!$space->is_available && $space->getCurrentEntry())
                                    <small>{{ $space->getCurrentEntry()->vehicle->plate }}</small>
                                @else
                                    <small>Libre</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection