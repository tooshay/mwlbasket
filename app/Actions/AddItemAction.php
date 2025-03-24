<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ItemStatus;
use App\Models\Item;

class AddItemAction
{
    public function execute(array $data): Item
    {
        $basket = auth()->user()->currentBasket();

        $existingItem = $basket->items()
            ->where('product_id', $data['product_id'])
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity');

            return $existingItem->fresh();
        }

        return $basket->items()->create([
            'product_id' => $data['product_id'],
            'status' => ItemStatus::ADDED->value,
            'quantity' => 1,
        ]);
    }
}
