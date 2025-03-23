<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
