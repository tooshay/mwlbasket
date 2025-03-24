<?php

namespace Database\Factories;

use App\Enums\ItemStatus;
use App\Models\Basket;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'basket_id' => Basket::factory(),
            'status' => ItemStatus::ADDED->value,
            'product_id' => fake()->randomElement(Product::all()->pluck('id')->toArray()),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }

    public function removed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => ItemStatus::REMOVED->value,
            ];
        });
    }

    public function purchased(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => ItemStatus::PURCHASED->value,
            ];
        });
    }
}
