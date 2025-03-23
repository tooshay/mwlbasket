<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('fixtures/products.json');

        if (!File::exists($path)) {
            $this->command->warn("Products file not found. Skipping seed.");

            return;
        }

        $json = File::get($path);
        $products = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($products)) {
            $this->command->error("Failed to decode products.json: " . json_last_error_msg());

            return;
        }

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(
                ['name' => $product['name']],
                ['price' =>  (int) round($product['price'] * 100)]
            );
        }

        $this->command->info('Products seeded successfully.');
    }
}
