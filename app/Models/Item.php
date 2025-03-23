<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ItemStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
    ];

    public function basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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
