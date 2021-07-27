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
        \App\Models\Area::create(["name" => "Salud"]);
        \App\Models\Area::create(["name" => "Deportes"]);
        \App\Models\Tag::create(["name" => "#Deportes"]);
        \App\Models\Tag::create(["name" => "#Noticias"]);
        \App\Models\Tag::create(["name" => "#Beneficios"]);
        \App\Models\Tag::create(["name" => "#Postulación"]);
        \App\Models\Tag::create(["name" => "#Cultura"]);
        \App\Models\Tag::create(["name" => "#Entretención"]);
        \App\Models\Tag::create(["name" => "#Investigación"]);


    }
}
