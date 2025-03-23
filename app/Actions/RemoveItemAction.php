<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ItemStatus;
use App\Models\Item;

class RemoveItemAction
{
    public function execute(array $data): Item
    {
        $basket = auth()->user()->currentBasket();

        $item = $basket->items()
            ->where('product_id', $data['product_id'])
            ->where('status', ItemStatus::ADDED->value)
            ->first();

        if ($item) {
            $item->update([
                'status' => ItemStatus::REMOVED->value,
            ]);
        }

        return $item;
    }
}
