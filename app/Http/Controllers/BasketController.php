<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\AddItemAction;
use App\Actions\CheckoutAction;
use App\Actions\RemoveItemAction;
use App\Http\Requests\AddItemRequest;
use App\Http\Requests\RemoveItemRequest;
use App\Http\Resources\BasketResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemResourceCollection;
use App\Repositories\ItemsRepository;
use Exception;
use Illuminate\Http\JsonResponse;

class BasketController extends Controller
{
    public function addItem(AddItemRequest $request, AddItemAction $addItemAction): ItemResource|JsonResponse
    {
        try {
            $item = $addItemAction->execute($request->validated());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return new ItemResource($item);
    }

    public function checkout(CheckoutAction $checkoutAction): JsonResponse
    {
        try {
            $basket = $checkoutAction->execute();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(
            [
                'message' => sprintf('Checkout successful for basket %s', $basket->id),
            ]
        );
    }

    public function get(): BasketResource|JsonResponse
    {
        try {
            $basket = auth()->user()->currentBasket()->load('items.product');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return new BasketResource($basket);
    }

    public function removeItem(RemoveItemRequest $request, RemoveItemAction $removeItemAction): ItemResource|JsonResponse
    {
        try {
            $item = $removeItemAction->execute($request->validated());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return new ItemResource($item);
    }

    public function removedItems(ItemsRepository $itemsRepository): ItemResourceCollection|JsonResponse
    {
        try {
            $items = $itemsRepository->findRemoved();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return new ItemResourceCollection($items);
    }
}
