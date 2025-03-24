<?php

namespace Database\Factories;

use App\Enums\ItemStatus;
use App\Models\Basket;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Basket>
 */
class BasketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'checked_out_at' => null,
            'total_amount' => 0,
        ];
    }

    public function withItems(int $count = 3): self
    {
        return $this->afterCreating(function (Basket $basket) use ($count) {
            $products = Product::inRandomOrder()->take($count)->get();
            $total = 0;

            foreach ($products as $product) {
                $basket->items()->create([
                    'product_id' => $product->id,
                    'status' => ItemStatus::ADDED->value,
                ]);
                $total += $product->price;
            }

            $basket->update(['total_amount' => $total]);
        });
    }
}
