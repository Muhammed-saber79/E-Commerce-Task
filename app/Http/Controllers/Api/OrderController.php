<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderCreatedNotification;
use App\Traits\GeneralTrait;
use App\Traits\OrderTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use GeneralTrait, OrderTrait;

    public function index()
    {
        $orders = Order::with('orderItems')->paginate(10);
        return view('Admin.Orders.index', compact('orders'));
    }

    public function store()
    {
        $user = auth()->user();
        $cartItems = $this->getUserCartItems($user);

        $order = $this->createOrder($user);
        if (!$order) {
            return $this->returnError(500, 'Can not create order now, try again later...!');
        }

        if ($user->hasRole('admin')) {
            $user->notify(new OrderCreatedNotification($order));
        }

        $this->createOrderItems($order, $cartItems);
        $this->updateCartItemsStatus($cartItems);

        return $this->returnData(201, 'Order created successfully.', ['order_id' => $order->id]);
    }
}
