<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            "name"          => "Aulas de Pilates 2V",
            "description"   => "Aulas de pilates duas vezes na semana",
            "unit_id"       => 1,
            "price"         => "29,58",
            "slug"          => "aulas-de-pilates-2v",
            "active"        => 1,
        ]);
    }
}
