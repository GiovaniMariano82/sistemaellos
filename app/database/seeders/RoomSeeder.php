<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            "name" => "Sala 1",
            "description" => "Descrição da sala 1 de pilates",
            "type_room_id" => 1,
            "customer_limit" => 0,
            "active" => 1
        ]);
    }
}
