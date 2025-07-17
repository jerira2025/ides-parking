<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documento;
use App\Models\User;

class LogDescarga extends Model
{
    use HasFactory;

    protected $table = 'logs_descargas'; // ← Aquí el cambio

    protected $fillable = ['documento_id', 'user_id', 'fecha', 'ip'];

    public $timestamps = false;

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
