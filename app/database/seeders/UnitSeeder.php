<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            "name"          => "Unidade",
            "acronym"       => "Un",
            "multiplier"    => 1,
            "active"        => 1,
        ]);

        Unit::create([
            "name"          => "Hora Aula",
            "acronym"       => "HA",
            "multiplier"    => 1,
            "active"        => 1,
        ]);
    }
}
