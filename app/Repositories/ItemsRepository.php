<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Basket;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ItemsRepository
{
    public function findWithBasket(Basket $basket): Collection
    {
        $item = app(Item::class);

        return $item->ofBasket($basket)->all();
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
