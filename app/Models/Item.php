<?php

namespace App\Models;

use App\Enums\ItemStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Item extends Model
{
    public function basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class);
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    public function scopeOfBasket(Builder $builder, Basket $basket): void
    {
        $builder->where('basket_id', $basket->id);
    }

    public function scopeRemoved(Builder $builder): void
    {
        $builder->where('status', ItemStatus::REMOVED->value);
    }
}
