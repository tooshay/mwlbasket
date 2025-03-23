<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@wmlbasket.com',
            'password' => Hash::make('password1234'),
            'role' => Role::ADMIN->value,
        ]);

        User::factory()->create([
            'name' => 'Roy Shay',
            'email' => 'roy@wmlbasket.com',
            'password' => Hash::make('password1234'),
            'role' => Role::CUSTOMER->value,
        ]);

        $this->call([
            ProductsSeeder::class,
        ]);
    }
}
