<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Descargas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; font-size: 12px; }
    </style>
</head>
<body>
    <h2>Reporte de Descargas de Documentos</h2>
    <table>
        <thead>
            <tr>
                <th>Documento</th>
                <th>Usuario</th>
                <th>IP</th>
                <th>Fecha Descarga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
            <tr>
                <td>{{ $log->documento->titulo ?? '' }}</td>
                <td>{{ $log->usuario->name ?? '' }}</td>
                <td>{{ $log->ip }}</td>
                <td>{{ $log->fecha_descarga }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
