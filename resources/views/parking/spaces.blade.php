@extends('layouts.app')

@section('content')
<div class="x_panel">
    <div class="x_title d-flex justify-content-between align-items-center">
        <h2>Visualización de Espacios Parqueadero</h2>
    </div>

    <div class="x_content">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif



        {{-- Filtros --}}
        <div class="mb-4">
            <button class="btn btn-secondary filter-btn" data-filter="all">Todos</button>
            <button class="btn btn-success filter-btn" data-filter="libre">Libres</button>
            <button class="btn btn-danger filter-btn" data-filter="ocupado">Ocupados</button>
        </div>

        {{-- Representación gráfica --}}
        <div class="row" id="espacios-container">
            @foreach($espacios as $espacio)
            <div class="col-md-2 col-sm-3 col-4 mb-3 espacio-card" data-estado="{{ strtolower($espacio->estado) }}">
                <div class="card text-center 
                @if($espacio->estado === 'libre') bg-success text-white
                @else bg-danger text-white
                @endif
            ">
                    <div class="card-body p-2">
                        <h5 class="card-title">Espacio {{ $espacio->numero_espacio }}</h5>

                        {{-- Línea divisoria --}}
                        <hr class="bg-light my-2">

                        {{-- Estado en negrita --}}
                        <p class="card-text mb-1 fw-bold">{{ ucfirst($espacio->estado) }}</p>

                        {{-- Zona --}}
                        <p class="card-text mb-1">{{ $espacio->zona->nombre ?? 'Sin zona' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


    </div>
</div>

{{-- Script para filtrar --}}
<script>
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            document.querySelectorAll('.espacio-card').forEach(card => {
                if (filter === 'all' || card.getAttribute('data-estado') === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection