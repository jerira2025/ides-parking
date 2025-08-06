<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibilidades extends Model
{
    protected $fillable = ['zona_id', 'tipo_vehiculo_id'];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class);
    }
}
