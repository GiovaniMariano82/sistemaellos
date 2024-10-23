<?php

namespace Database\Seeders;

use App\Models\TypeContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeContact::create([
            "name"=> "Telefone Fixo",
        ]);

        TypeContact::create([
            "name"=> "Celular",
        ]);

        TypeContact::create([
            "name"=> "E-mail",
        ]);

        TypeContact::create([
            "name"=> "WhatsApp",
        ]);

        TypeContact::create([
            "name"=> "Recado",
        ]);
    }
}
