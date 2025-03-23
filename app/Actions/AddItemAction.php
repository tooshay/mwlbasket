<?php

namespace App\Actions;

use App\Enums\ItemStatus;
use App\Models\Item;

class AddItemAction
{
    public function execute(array $data): Item
    {
        $basket = auth()->user()->currentBasket();

        return $basket->items()->create([
            'product_id' => $data['product_id'],
            'status' => ItemStatus::ADDED->value,
        ]);
    }
}
