<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Categoria;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDocumentos = Documento::count();

        $porCategoria = Categoria::withCount('documentos')->get();
        $porTipo = TipoDocumento::withCount('documentos')->get();

        $porMes = Documento::selectRaw('DATE_TRUNC(\'month\', fecha_documento) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('dashboard.index', compact(
            'totalDocumentos',
            'porCategoria',
            'porTipo',
            'porMes'
        ));
        
    }

}
