<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\AddItemAction;
use App\Actions\CheckoutAction;
use App\Actions\RemoveItemAction;
use App\Enums\ItemStatus;
use App\Http\Requests\ManipulateItemRequest;
use App\Repositories\ItemsRepository;
use Exception;
use Illuminate\Http\JsonResponse;

class BasketController extends Controller
{
    public function addItem(ManipulateItemRequest $request, AddItemAction $addItemAction): JsonResponse
    {
        try {
            $addItemAction->execute($request->validated());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Item added to basket']);
    }

    public function checkout(CheckoutAction $checkoutAction): JsonResponse
    {
        try {
            $checkoutAction->execute();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Checkout successful']);
    }

    public function get(): JsonResponse
    {
        try {
            $basket = auth()->user()->currentBasket()->load('items.product');

            return response()->json([
                'basket_id' => $basket->id,
                'items' => $basket->items,
                'total_value' => $basket->items->where('status', ItemStatus::ADDED->value)->sum(fn ($item) => $item->product->price),
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function removeItem(ManipulateItemRequest $request, RemoveItemAction $removeItemAction): JsonResponse
    {
        try {
            $removeItemAction->execute($request->validated());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Item removed from basket']);
    }

    public function removedItems(ItemsRepository $itemsRepository): JsonResponse
    {
        try {
            return response()->json($itemsRepository->findRemoved()->toJson());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
