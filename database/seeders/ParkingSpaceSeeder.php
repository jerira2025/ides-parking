<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingSpace;

class ParkingSpaceSeeder extends Seeder
{
    public function run()
    {
        $zones = ['A', 'B', 'C', 'D', 'E'];
        
        for ($i = 1; $i <= 50; $i++) {
            ParkingSpace::create([
                'zone' => $zones[($i - 1) % 5], // Distribuir en zonas
                'is_available' => true
            ]);
        }
    }
}