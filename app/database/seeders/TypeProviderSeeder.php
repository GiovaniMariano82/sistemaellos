<?php

namespace Database\Seeders;

use App\Models\TypeProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeProvider::create([
            "name"=> "Fisioterapeuta",
            "active"=> 1,
        ]);
        TypeProvider::create([
            "name"=> "Educador Físico",
            "active"=> 1,
        ]);
        TypeProvider::create([
            "name"=> "Nutricionista",
            "active"=> 1,
        ]);
        TypeProvider::create([
            "name"=> "Médico",
            "active"=> 1,
        ]);
    }
}
