<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espacios_parqueadero extends Model
{
    use HasFactory;
    protected $table = 'espacios_parqueadero';

    protected $fillable = [
        'numero_espacio',
        'zona_id',
        'tipo_vehiculo_id'
    ];

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'zona_id');
    }



    public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class);
    }

    public function entradas()
    {
        return $this->hasMany(VehicleEntry::class, 'espacio_id');
    }

    public function vehicleEntries()
{
    return $this->hasMany(VehicleEntry::class, 'espacio_id');
}
}
