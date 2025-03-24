<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Basket;
use App\Models\Item;
use Illuminate\Support\Collection;

class ItemsRepository
{
    public function findWithBasket(Basket $basket): Collection
    {
        $item = app(Item::class);

        return $item->ofBasket($basket)->all();
    }

    public function findRemoved($since = null): Collection
    {
        $item = app(Item::class);

        return $item->removed()->get();
    }
}
