@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📄 Detalle del Documento</h2>

    <div class="card shadow rounded-4 border-0">
        <div class="card-body px-5 py-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>📌 Título:</strong> {{ $documento->titulo }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>📅 Fecha:</strong> {{ $documento->fecha_documento }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>📂 Categoría:</strong> {{ optional($documento->categoria)->nombre ?? 'Sin categoría' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>🗂 Tipo:</strong> {{ optional($documento->tipoDocumento)->nombre ?? 'Sin tipo' }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <p><strong>📄 Descripción:</strong></p>
                    <div class="border rounded p-3 bg-light">
                        {{ $documento->descripcion ?? 'Sin descripción' }}
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <a href="{{ route('documentos.descargar', $documento->id) }}" class="btn btn-success btn-lg rounded-pill shadow-sm">
                        <i class="fa fa-download"></i> Descargar Archivo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <a href="{{ route('documentos.index') }}" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="fa fa-arrow-left"></i> Volver al listado
        </a>
    </div>
</div>
@endsection