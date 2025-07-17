<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Categoria;
use App\Models\TipoDocumento;
use App\Models\LogDescarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\LogsDescargaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\DocumentoNotificado;
use App\Models\User; 

class DocumentoController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::all();
        $tipos = TipoDocumento::all();

        $query = Documento::with('categoria', 'tipoDocumento');


        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('tipo_documento_id')) {
            $query->where('tipo_documento_id', $request->tipo_documento_id);
        }

        if ($request->filled('buscar')) {
            $query->where('titulo', 'ILIKE', '%' . $request->buscar . '%');
        }

        $documentos = $query->latest()->paginate(10)->withQueryString();

        return view('documentos.index', compact('documentos', 'categorias', 'tipos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $tipos = TipoDocumento::all();
        return view('documentos.create', compact('categorias', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'archivo' => 'required|file|mimes:pdf,docx,xlsx,jpg,png',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'fecha_documento' => 'required|date',
            'confidencial' => 'nullable|boolean',
        ]);

        $archivo = $request->file('archivo')->store('public/documentos');

        Documento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'archivo' => str_replace('public/', 'storage/', $archivo),
            'categoria_id' => $request->categoria_id,
            'tipo_documento_id' => $request->tipo_documento_id,
            'fecha_documento' => $request->fecha_documento,
            'user_id' => Auth::id(),
            'confidencial' => $request->has('confidencial'),
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento cargado correctamente.');
    }

    public function descargar($id)
    {
        $documento = Documento::findOrFail($id);

        // Registrar en logs
        LogDescarga::create([
            'documento_id' => $documento->id,
            'user_id' => Auth::id(),
            'fecha' => now(),
            'ip' => request()->ip(),
        ]);

        return response()->download(public_path($documento->archivo));
    }

    public function edit($id)
    {
        $documento = Documento::findOrFail($id);
        $tipos = TipoDocumento::all();
        $categorias = Categoria::all();

        return view('documentos.edit', compact('documento', 'tipos', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'categoria_id' => 'required|exists:categorias,id',
            'archivo' => 'nullable|file|max:5120', // max 5MB
        ]);

        $datos = $request->only(['titulo', 'descripcion', 'tipo_documento_id', 'categoria_id']);

        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior
            if (Storage::exists($documento->archivo)) {
                Storage::delete($documento->archivo);
            }
            $datos['archivo'] = $request->file('archivo')->store('documentos');
        }

        $documento->update($datos);

        return redirect()->route('documentos.index')->with('success', 'Documento actualizado correctamente.');
    }



    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);
        $rutaArchivo = public_path($documento->archivo);

        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }

        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado.');
    }

    public function exportarExcel()
    {
        return Excel::download(new LogsDescargaExport, 'logs_descargas.xlsx');
    }

    public function exportarPDF()
    {
        $logs = LogDescarga::with(['documento', 'usuario'])->get();
        $pdf = Pdf::loadView('logs.pdf', compact('logs'))->setPaper('a4', 'landscape');

        return $pdf->download('logs_descargas.pdf');
    }
    public function exportarLog(Request $request)
    {
        $query = LogDescarga::with(['documento', 'usuario']);

        if ($request->filled('usuario_id')) {
            $query->where('user_id', $request->usuario_id);
        }

        if ($request->filled('documento_id')) {
            $query->where('documento_id', $request->documento_id);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $logs = $query->latest()->paginate(10)->withQueryString();

        // Estas son las variables que faltaban
        $usuarios = \App\Models\User::all();
        $documentos = \App\Models\Documento::all();

        return view('logs.index', compact('logs', 'usuarios', 'documentos'));
    }

    public function show($id)
    {
        $documento = Documento::findOrFail($id);
        return view('documentos.show', compact('documento'));
    }
}
