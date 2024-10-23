<?php

namespace Database\Seeders;

use App\Models\TypeRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeRoom::create([
            "name" => "Sala de Pilates",
            "active" => 1
        ]);
    }
}
