<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ItemStatus;
use App\Models\Item;
use App\Models\Product;
use App\Repositories\ItemsRepository;

readonly class AddItemAction
{
    public function __construct(
        private ItemsRepository $itemsRepository
    ) {}

    public function execute(array $data): Item
    {
        $basket = auth()->user()->currentBasket();

        $existingItem = $this->itemsRepository->findBasketItemByProduct(
            $basket->id,
            $data['product_id']
        );

        $product = Product::findOrFail($data['product_id']);

        if ($existingItem) {
            $existingItem->increment('quantity');
            $existingItem->price = $product->price * $existingItem->quantity;
            $existingItem->save();

            return $existingItem->fresh();
        }

        $item = new Item([
            'product_id' => $data['product_id'],
            'status' => ItemStatus::ADDED->value,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        $item->basket_id = $basket->id;
        $item->save();

        return $item;
    }
}
