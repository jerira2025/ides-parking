@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content_header')
    <h1><b>Bienvenido</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <p class="lead">Hola, {{ Auth::user()->name }}. Bienvenido al panel de administración.</p>
                {{-- Agrega aquí los accesos directos o resumen de módulos --}}
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- Agrega estilos personalizados si los necesitas --}}
    {{-- <link rel="stylesheet" href="/css/custom.css"> --}}
@stop

@section('js')
    {{-- Agrega scripts personalizados si los necesitas --}}
    {{-- <script>console.log('Admin panel ready');</script> --}}
@stop