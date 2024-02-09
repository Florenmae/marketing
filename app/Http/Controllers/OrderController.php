<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cartItems = Cart::all();

        $orderItems = [];
        foreach ($cartItems as $cartItem) {
            $orderItems[] = [
                'product_id' => $cartItem->product_id,
                'name' => $cartItem->name,
                'price' => $cartItem->price,
                'quantity' => $cartItem->quantity,
                'total' => $cartItem->total
            ];
        }

        $order = new Order();
        $order->items()->createMany($orderItems);

        // Clear the cart
        Cart::truncate();

        return response()->json(['message' => 'Checkout successful']);
    }
}
