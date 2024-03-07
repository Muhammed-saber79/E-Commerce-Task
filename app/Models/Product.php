<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function cartItem()
    {
        return $this->hasOne(CartItem::class);
    }

    public function orderItem()
    {
        return $this->hasOne(OrderItem::class);
    }
}
