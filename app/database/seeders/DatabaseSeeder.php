<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        /*App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        //\App\Models\Product::factory(20)->create();

        $this->call(UserSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(TypeContactSeeder::class);
        $this->call(TypeDocumentSeeder::class);
        $this->call(TypeGenderSeeder::class);
        $this->call(TypeProviderSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(TypeRoomSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(PaymentMethodSeeder::class);
    }
}
