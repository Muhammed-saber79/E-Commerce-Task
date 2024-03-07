<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddToCartRequest;
use App\Http\Requests\Api\RemoveFromCartRequest;
use App\Http\Requests\Api\UpdateQuantityRequest;
use App\Http\Resources\CartItemsResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\CartService;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use GeneralTrait;

    public function __construct(public CartService $cartService){}

    public function add_product_to_cart(AddToCartRequest $request)
    {
        $result = $this->cartService->add_product_to_cart($request);
        if ($result['status'] == 'failed') {
            return $this->returnError(422, $result['message']);
        }

        //return $this->returnSuccess(201, $result['message']);
        return $this->returnData(200, $result['message'], $result['created_data']);
    }

    public function remove_product_from_cart(RemoveFromCartRequest $request)
    {
        $result = $this->cartService->remove_product_from_cart($request);
        if ($result['status'] == 'failed') {
            return $this->returnError(422, $result['message']);
        }

        return $this->returnSuccess(201, $result['message']);
    }

    public function increase_quantity(UpdateQuantityRequest $request)
    {
        $result = $this->cartService->increase_quantity($request);
        if ($result['status'] == 'failed') {
            return $this->returnError(422, $result['message']);
        }

        return $this->returnSuccess(201, $result['message']);
    }

    public function decrease_quantity(UpdateQuantityRequest $request)
    {
        $result = $this->cartService->decrease_quantity($request);
        if ($result['status'] == 'failed') {
            return $this->returnError(422, $result['message']);
        }

        return $this->returnSuccess(201, $result['message']);
    }

    public function cart_items(Cart $cart)
    {
        $cartItems = $cart->cartItems;

        return $cart;
        return $this->returnData(200, "Retrieve cart items.", CartItemsResource::collection($cartItems));
    }
}
