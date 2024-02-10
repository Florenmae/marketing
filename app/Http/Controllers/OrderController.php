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
                'name' => $order->name,
                'product_id' => $order->product_id,
                'image' => $order->image,
                'description' => $order->description,
                'price' => $order->price,
                'quantity' => $order->quantity,
                'total' => $order->total,
                'balance' => $order->balance,
                'paymentMethod' => $order->paymentMethod,
                'created_at' => Carbon::parse($order->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($order->updated_at)->format('Y-m-d'),
            ];
        });

        return response()->json($formattedOrders);
    }

}
