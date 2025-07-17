<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    public function run()
    {
        $tipos = ['Interno', 'Público', 'Confidencial'];
        foreach ($tipos as $tipo) {
            DB::table('tipos_documento')->insert([
                'nombre' => $tipo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
