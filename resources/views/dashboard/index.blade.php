@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fa fa-chart-bar"></i> Panel de Estadísticas</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white bg-primary">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fa fa-file-alt"></i> Total de Documentos</h5>
                    <h2 class="card-text">{{ $totalDocumentos }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Documentos por Categoría -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fa fa-folder-open"></i> Documentos por Categoría
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($porCategoria as $cat)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $cat->nombre }}
                            <span class="badge bg-primary rounded-pill" style="color: white;">{{ $cat->documentos_count }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">No hay datos.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Documentos por Tipo -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <i class="fa fa-tags"></i> Documentos por Tipo
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($porTipo as $tipo)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $tipo->nombre }}
                            <span class="badge bg-success rounded-pill" style="color: white;">{{ $tipo->documentos_count }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">No hay datos.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Documentos por Mes -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <i class="fa fa-calendar-alt"></i> Documentos por Mes
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($porMes as $m)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ \Carbon\Carbon::parse($m->mes)->translatedFormat('F Y') }}
                            <span class="badge bg-dark rounded-pill" style="color: white;">{{ $m->total }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">No hay datos.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
