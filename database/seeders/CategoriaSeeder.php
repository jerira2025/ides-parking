<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Circulares', 'descripcion' => 'Comunicaciones internas o externas'],
            ['nombre' => 'Resoluciones', 'descripcion' => 'Normas emitidas por la entidad'],
            ['nombre' => 'Actas', 'descripcion' => 'Registros de reuniones'],
            ['nombre' => 'Manuales', 'descripcion' => 'Documentos guía'],
        ];

        foreach ($categorias as $cat) {
            Categoria::create($cat);
        }
    }
}
