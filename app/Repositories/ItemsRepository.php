<?php

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

    public function findRemoved(): Collection
    {
        $item = app(Item::class);

        return $item->removed()->get();
    }
}
