<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**Criar um registro de status Ativo */
        Status::create([
            "name"          => "Ativo",
            "description"   =>  "Clientes que estão ativos na plataforma",
            "active"        => 1,
        ]);

        /**Criar um registro de status Inativo */
        Status::create([
            "name"          => "Inativo",
            "description"   =>  "Clientes que estão inativos na plataforma",
            "active"        => 1,
        ]);
    }
}
