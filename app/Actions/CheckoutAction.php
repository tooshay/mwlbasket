<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ItemStatus;
use App\Models\Basket;

class CheckoutAction
{
    public function execute(): Basket
    {
        $basket = auth()->user()->currentBasket();
        $basket->checked_out_at ??= now();
        $basket->save();

        $basket->items()->update([
            'status' => ItemStatus::PURCHASED->value,
        ]);

        return $basket;
    }
}
