<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documento';

    protected $fillable = ['nombre'];

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'tipo_documento_id');
    }
}
