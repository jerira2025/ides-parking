<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{
    protected $fillable = ['codigo', 'nombre'];

    public function espacios()
{
    return $this->hasMany(Espacios_parqueadero::class);
}

    public function compatibilidades()
{
    return $this->hasMany(Compatibilidades::class);
}

// public function zonas()
// {
//     return $this->belongsToMany(Zona::class, 'zona_tipo_vehiculo');
// }

// App\Models\TipoVehiculo.php

public function zonas()
{
    return $this->belongsToMany(Zona::class, 'compatibilidades', 'tipo_vehiculo_id', 'zona_id');
}


}


