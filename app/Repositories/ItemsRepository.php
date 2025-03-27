<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\ItemStatus;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ItemsRepository
{
    public function findBasketItem(int $basketId, mixed $itemId, ?ItemStatus $status = null): ?Item
    {
        $query = Item::where('basket_id', $basketId)
            ->where('id', (int) $itemId);

        if ($status !== null) {
            $query->where('status', $status->value);
        }

        return $query->first();
    }

    public function findBasketItemByProduct(int $basketId, int $productId): ?Item
    {
        return Item::where('basket_id', $basketId)
            ->where('product_id', $productId)
            ->first();
    }

    public function findRemoved(?int $daysBack = null): Collection
    {
        $query = app(Item::class)->removed();

        if ($daysBack !== null) {
            $query->where('updated_at', '>=', Carbon::now()->subDays($daysBack));
        }

        return $query->get();
    }
}
