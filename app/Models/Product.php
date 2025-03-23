<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}
