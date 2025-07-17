@extends('layouts.app')

@section('content')
<div class="container">
    <h2>➕ Nuevo Tipo de Documento</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo problemas con los datos ingresados:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tipo_documentos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Tipo de Documento</label>
            <input type="text" name="nombre" class="form-control" placeholder="Ej: Confidencial" value="{{ old('nombre') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('tipo_documentos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
