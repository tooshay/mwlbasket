<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ItemStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $basket_id
 * @property int $product_id
 * @property int $quantity
 * @property int $price
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Basket $basket
 * @property-read \App\Models\Product $product
 * @method static \Database\Factories\ItemFactory factory($count = null, $state = [])
 * @method static Builder<static>|Item newModelQuery()
 * @method static Builder<static>|Item newQuery()
 * @method static Builder<static>|Item ofBasket(\App\Models\Basket $basket)
 * @method static Builder<static>|Item query()
 * @method static Builder<static>|Item removed()
 * @method static Builder<static>|Item whereBasketId($value)
 * @method static Builder<static>|Item whereCreatedAt($value)
 * @method static Builder<static>|Item whereId($value)
 * @method static Builder<static>|Item wherePrice($value)
 * @method static Builder<static>|Item whereProductId($value)
 * @method static Builder<static>|Item whereQuantity($value)
 * @method static Builder<static>|Item whereStatus($value)
 * @method static Builder<static>|Item whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
