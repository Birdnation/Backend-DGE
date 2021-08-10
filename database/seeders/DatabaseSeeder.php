<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create(['name' => 'Administrador',
            'email' => 'admin@ucn.cl',
            'rol' => 'Administrador',
            'password' => bcrypt(123456)]);
        \App\Models\User::create(['name' => 'Coordinador Salud',
            'email' => 'salud@ucn.cl',
            'rol' => 'Salud',
            'password' => bcrypt(123456)]);
        \App\Models\User::create(['name' => 'Coordinador Deportes',
            'email' => 'deportes@ucn.cl',
            'rol' => 'Deportes',
            'password' => bcrypt(123456)]);
        \App\Models\Area::create(["name" => "Salud"]);
        \App\Models\Area::create(["name" => "Deportes"]);
        \App\Models\Area::create(["name" => "Beneficios"]);
        \App\Models\Area::create(["name" => "Arte y Cultura"]);
        \App\Models\Area::create(["name" => "Jardin Infantil"]);
        \App\Models\Area::create(["name" => "Inclusión"]);
        \App\Models\Tag::create(["name" => "Deportes"]);
        \App\Models\Tag::create(["name" => "Noticias"]);
        \App\Models\Tag::create(["name" => "Beneficios"]);
        \App\Models\Tag::create(["name" => "Postulación"]);
        \App\Models\Tag::create(["name" => "Cultura"]);
        \App\Models\Tag::create(["name" => "Entretención"]);
        \App\Models\Tag::create(["name" => "Investigación"]);


    }
}
