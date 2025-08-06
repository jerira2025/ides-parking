<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];


    public function espacios()
{
    return $this->hasMany(Espacios_parqueadero::class, 'zona_id');
}


    public function compatibilidades()
    {
        return $this->hasMany(Compatibilidades::class);
    }

    public function tipoVehiculos()
    {
        return $this->belongsToMany(TipoVehiculo::class, 'zona_tipo_vehiculo');
    }
}
