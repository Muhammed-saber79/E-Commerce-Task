<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderItem;

trait OrderTrait
{
    protected function getUserCartItems($user)
    {
        return $user->cart->cartItems()->where('status', 'new')->get();
    }

    protected function createOrder($user)
    {
        return Order::create(['user_id' => $user->id]);
    }

    protected function createOrderItems($order, $cartItems)
    {
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
            ]);
        }
    }

    protected function updateCartItemsStatus($cartItems)
    {
        $cartItems->each(function ($cartItem) {
            $cartItem->update(['status' => 'ordered']);
        });
    }
}
