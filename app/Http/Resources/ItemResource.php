<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'basket_id' => $this->basket_id,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'added' => $this->created_at,
            'product' => ProductResource::make($this->product),
        ];
    }
}
