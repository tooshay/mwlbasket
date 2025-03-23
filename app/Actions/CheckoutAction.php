<?php

namespace App\Actions;

use App\Enums\ItemStatus;
use Illuminate\Support\Collection;

class CheckoutAction
{
    public function execute(): Collection
    {
        $basket = auth()->user()->currentBasket();

        $basket->items()->update([
            'status' => ItemStatus::PURCHASED->value,
        ]);

        return $basket->items()->get();
    }
}
