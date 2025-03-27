<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ItemStatus;
use App\Models\Basket;
use App\Repositories\ItemsRepository;

readonly class CheckoutAction
{
    public function __construct(
        private ItemsRepository $itemsRepository
    ) {}
    
    public function execute(): Basket
    {
        $basket = auth()->user()->currentBasket();
        $basket->checked_out_at ??= now();
        $basket->save();

        // Get added items using repository
        $items = $this->itemsRepository->findBasketItemsByStatus($basket->id, ItemStatus::ADDED);
        
        // Update each item (avoiding update logic in the repository)
        foreach ($items as $item) {
            $item->status = ItemStatus::PURCHASED->value;
            $item->save();
        }

        return $basket;
    }
}
