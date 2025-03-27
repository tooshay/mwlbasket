<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ItemStatus;
use App\Models\Item;
use App\Repositories\ItemsRepository;
use Exception;

readonly class RemoveItemAction
{
    public function __construct(
        private ItemsRepository $itemsRepository
    ) {}

    /**
     * @throws Exception
     */
    public function execute(array $data): Item
    {
        $basket = auth()->user()->currentBasket();

        $item = $this->itemsRepository->findBasketItem(
            $basket->id,
            (int) $data['item_id'],
            ItemStatus::ADDED->value
        );

        if (! $item) {
            throw new Exception('Item not found or already removed');
        }

        $item->update([
            'status' => ItemStatus::REMOVED->value,
            'quantity' => 0,
        ]);

        return $item;
    }
}
