<?php

namespace App\Traits;

use App\Models\Cart;
use App\Models\CartItem;

trait CartTrait
{
    protected function getUserId($request)
    {
        return $request->user()->id;
    }

    protected function getUserCart($userId)
    {
        return Cart::where('user_id', $userId)->firstOrCreate(['user_id' => $userId]);
    }

    protected function createCartItem($cart, $request)
    {
        $existingCartItem = $cart->cartItems()->where('product_id', $request->product_id)->where('status', 'new')->first();
        if ($existingCartItem) {
            throw new \Exception('Item already exists...!');
        }

        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
        ]);
    }

    private function updateQuantity($request, $change, $action)
    {
        $user = auth()->user();
        $cartItem = $user->cart->cartItems()->where('id', $request->cart_item_id)->first();

        if (!$cartItem) {
            return ['status' => 'failed', 'message' => 'Cart item not found'];
        }

        try {
            $cartItem->quantity += $change;

            if ($cartItem->quantity < 1) {
                $cartItem->delete();
                return ['status' => 'success', 'message' => 'Product removed from cart'];
            }

            $cartItem->save();
            return ['status' => 'success', 'message' => "Product quantity $action successfully"];
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'message' => 'Can not update the item quantity...!'
            ];
        }
    }
}
