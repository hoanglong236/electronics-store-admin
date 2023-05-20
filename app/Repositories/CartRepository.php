<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository implements ICartRepository
{
    public function create(array $attributes)
    {
        return Cart::create($attributes);
    }
}
