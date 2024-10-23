<?php

namespace Database\Seeders;

use App\Models\TypeGender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeGender::create([
            "name"=> "Masculino",
        ]);
        TypeGender::create([
            "name"=> "Feminino",
        ]);
    }
}
