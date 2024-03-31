<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function fetchOrders (Request $request){
        $orders = Order::all();

        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'customerId' => $order->customerId,
                'productId' => $order->productId,
                'image' => $order->image,
                'description' => $order->description,
                'price' => $order->price,
                'qty' => $order->qty,
                'total' => $order->total,
                'balance' => $order->balance,
                'paymentMethod' => $order->paymentMethod,
                'created_at' => Carbon::parse($order->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($order->updated_at)->format('Y-m-d'),
            ];
        });

        return response()->json($formattedOrders);
    }

    public function viewOrder(Request $request){

    if(Order::where('id', $request->id)->exists()){
        return Order::find($request->id);
    }
    else{
        return $data = (object)[
            "id"=>0,
            "name"=> "",

        ];
    }
}

}
