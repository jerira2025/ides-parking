<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ParkingTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_plate',
        'entry_time',
        'exit_time',
        'hourly_rate',
        'total_hours',
        'total_cost'
    ];

    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
        'hourly_rate' => 'decimal:2',
        'total_hours' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function calculateTotals(): void
    {
        if ($this->entry_time && $this->exit_time) {
            $minutes = $this->entry_time->diffInMinutes($this->exit_time);
            $hours = $minutes / 60;
            // redondeo al alza a 2 decimales (si prefieres, ceil por hora completa usa ceil($hours))
            $hoursRounded = round($hours, 2);
            $this->total_hours = $hoursRounded;
            $this->total_cost = bcmul((string) $hoursRounded, (string) $this->hourly_rate, 2);
        }
    }
}