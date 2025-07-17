@extends('layouts.app')

@section('content')
<div class="container">
    <h2>✏️ Editar Tipo de Documento</h2>

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

    <form action="{{ route('tipo-documentos.update', $tipo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Tipo de Documento</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tipo->nombre) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('tipo-documentos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
