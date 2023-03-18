<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create(['nombre'=> 'Tecnology', 'estado' => 'activa']);
        Categoria::create(['nombre'=> 'Electrodomesty', 'estado' => 'activa']);
        Categoria::create(['nombre'=> 'Hombre', 'estado' => 'activa']);
        Categoria::create(['nombre'=> 'Kids', 'estado' => 'activa']);
        Categoria::create(['nombre'=> 'Mascotas', 'estado' => 'activa']);
        Categoria::create(['nombre'=> 'Casas', 'estado' => 'activa']);
        Categoria::create(['nombre'=> 'Muebles', 'estado' => 'activa']);
        Categoria::create(['nombre'=> 'Tools', 'estado' => 'activa']);
        Categoria::create(['nombre'=> 'Deportes', 'estado' => 'activa']);
    }
}
