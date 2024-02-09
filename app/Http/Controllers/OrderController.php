<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // public function checkout(Request $request)
    // {
    //     $cartItems = Cart::all();

    //     $orderItems = [];
    //     foreach ($cartItems as $cartItem) {
    //         $orderItems[] = [
    //             'product_id' => $cartItem->product_id,
    //             'name' => $cartItem->name,
    //             'price' => $cartItem->price,
    //             'quantity' => $cartItem->quantity,
    //             'total' => $cartItem->total
    //         ];
    //     }

    //     $order = new Order();
    //     $order->items()->createMany($orderItems);

    //     // Clear the cart
    //     Cart::truncate();

    //     return response()->json(['message' => 'Checkout successful']);
    // }

    public function fetchOrders (Request $request){
        $orders = OrderProduct::all();

        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'quantity' => $order->quantity,
                'total' => $order->total,
                'created_at' => Carbon::parse($order->created_at)->format('Y-m-d'),
            ];
        });

        return response()->json($formattedOrders);
    }

}
