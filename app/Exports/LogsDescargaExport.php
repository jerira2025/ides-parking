<?php

namespace App\Exports;

use App\Models\LogDescarga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogsDescargaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return LogDescarga::with(['documento', 'usuario'])->get()->map(function ($log) {
            return [
                'Documento' => $log->documento->titulo ?? '',
                'Usuario' => $log->usuario->name ?? '',
                'IP' => $log->ip,
                'Fecha Descarga' => $log->fecha_descarga,
            ];
        });
    }

    public function headings(): array
    {
        return ['Documento', 'Usuario', 'IP', 'Fecha Descarga'];
    }
}