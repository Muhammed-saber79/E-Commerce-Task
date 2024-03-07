<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Traits\CartTrait;

class CartService
{
    use CartTrait;

    public function add_product_to_cart($request)
    {
        $userId = auth()->id();
        $cart = $this->getUserCart($userId);
        try {
            $cartItem = $this->createCartItem($cart, $request);
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'message' => $e->getMessage()//'Failed to add item to cart or it is already exists...!'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Item added successfully.',
            'created_data' => $cartItem,
        ];
    }

    public function remove_product_from_cart($request)
    {
        $user = auth()->user();

        if (!$cart = $user->cart) {
            return ['status' => 'failed', 'message' => 'Cart not found'];
        }

        if (!$cartItem = $cart->cartItems()->where('id', $request->cart_item_id)->first()) {
            return ['status' => 'failed', 'message' => 'Cart item not found'];
        }

        $cartItem->delete();
        return ['status' => 'success', 'message' => 'Product removed from cart successfully'];
    }

    public function increase_quantity($request)
    {
        return $this->updateQuantity($request, 1, 'increased');
    }

    public function decrease_quantity($request)
    {
        return $this->updateQuantity($request, -1, 'decreased');
    }


}
