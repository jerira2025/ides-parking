<?php

namespace Database\Seeders;
use App\Models\Zona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zonas = ['general', 'moto', 'vip', 'discapacitado'];

        foreach ($zonas as $nombre) {
    Zona::firstOrCreate(['nombre' => $nombre]);}
    }
}
