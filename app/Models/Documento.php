<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'archivo',
        'categoria_id',
        'tipo_documento_id',
        'fecha_documento',
        'user_id',
        'confidencial',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
