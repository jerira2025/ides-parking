@extends('layouts.app')

@section('content')
<div class="container">
    <div class="x_panel">
        <div class="x_title">
            <h2>Registro de Descargas de Documentos</h2>
            <div class="clearfix"></div>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('documentos.log.index') }}" class="mb-3 row g-3">
            <div class="col-md-3">
                <label for="usuario_id">Usuario</label>
                <select name="usuario_id" id="usuario_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ request('usuario_id') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="documento_id">Documento</label>
                <select name="documento_id" id="documento_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($documentos as $documento)
                        <option value="{{ $documento->id }}" {{ request('documento_id') == $documento->id ? 'selected' : '' }}>
                            {{ $documento->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
            </div>

            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('documentos.log.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>

        <!-- Botones de exportación -->
        <div class="mb-3">
            <a href="{{ route('logs.exportar.excel') }}" class="btn btn-success">
                <i class="fa fa-file-excel-o"></i> Exportar a Excel
            </a>
            <a href="{{ route('logs.exportar.pdf') }}" class="btn btn-danger">
                <i class="fa fa-file-pdf-o"></i> Exportar a PDF
            </a>
        </div>

        <!-- Contenido -->
        <div class="x_content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($logs->isEmpty())
                <p>No se han registrado descargas aún.</p>
            @else
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Documento</th>
                            <th>Usuario</th>
                            <th>IP</th>
                            <th>Fecha de Descarga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $logs->firstItem() + $loop->index }}</td>
                                <td>{{ $log->documento->titulo ?? 'N/A' }}</td>
                                <td>{{ $log->usuario->name ?? 'N/A' }}</td>
                                <td>{{ $log->ip }}</td>
                                <td>{{ $log->fecha }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="d-flex justify-content-center">
                    {{ $logs->links() }}
                </div>
            @endif
        </div> <!-- /.x_content -->
    </div> <!-- /.x_panel -->
</div> <!-- /.container -->
@endsection
