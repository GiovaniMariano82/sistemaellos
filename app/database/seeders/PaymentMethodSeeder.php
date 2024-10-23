<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::create([
            'name' => 'Dinheiro',
            'description' => 'Pagamento em espécie',
            'has_input_box' => 1,
            'active' => 1,
        ]);

        PaymentMethod::create([
            'name' => 'Cartão de Crédito',
            'description' => 'Pagamento utiliando o cartão de crédito',
            'has_input_box' => 0,
            'active' => 1,
        ]);
    }
}
