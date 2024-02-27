<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Categories;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ReturnedProduct;

class PosController extends Controller
{
    public function fetchProducts(){
        return Product::all();
    }

    public function fetchCategories(){
        return Categories::all();
    }

    public function addToCart(Request $request)
{
    $productId = $request->input('productId');
    $qty = $request->input('qty', 1);

    $cartItem = Cart::where('productName', $request->input('productName'))
                    ->where('price', $request->input('price'))
                    ->first();

    if ($cartItem) {
        $cartItem->qty += $qty;
        $cartItem->total = $cartItem->qty * $cartItem->price;
        $cartItem->save();
    } else {
        Cart::create([
            'productId' => $productId,
            'customerName' => $request->input('customerName'),
            'productName' => $request->input('productName'),
            'image' => $request->input('image'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'description' => $request->input('description'),
            'total' => $request->input('price') * $qty,
            'qty' => $qty,
        ]);
    }

    return response()->json(['message' => 'Product added to cart']);
}


    // public function showCartItem(Request $request)
    // {
    //     if ($request->wantsJson()) {
    //         return response(
    //             $request->user()->cart()->get()
    //         );
    //     }
    //     return view('cart.index');
    // }

    public function showCartItem(Request $request){
        return Cart::all();
    }

    public function deleteItem(Request $request){
        $deleteItem = Cart::find($request->id);

        $res = $deleteItem->delete();
        return $res;
    }

    public function checkout(Request $request)
{
    $cartItems = Cart::all();
    $totalAmount = 0;

    foreach ($cartItems as $cartItem) {
        $totalAmount += $cartItem->total;
    }

    $paymentMethod = $request->input('paymentMethod');
    $amountGiven = $request->input('amountGiven');


    if ($amountGiven >= $totalAmount) {
        $balance = 0;
        $changeAmount = $amountGiven - $totalAmount;
    } else {
        $balance = $totalAmount - $amountGiven;
        $changeAmount = 0;
    }


    $orderItems = [];
    $now = now();

    foreach ($cartItems as $cartItem) {
        $orderItems[] = [
            'productId' => $cartItem->productId,
            'customerId' => $cartItem->customerId,
            'price' => $cartItem->price,
            'qty' => $cartItem->qty,
            'total' => $cartItem->total,
            'description' => $cartItem->description,
            'image' => $cartItem->image,
            'paymentMethod' => $paymentMethod,
            'balance' => $balance,
            'changeAmount' => $changeAmount,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    $orderProduct = new OrderProduct();
    $orderProduct->insert($orderItems);

    Cart::truncate();

    return response()->json(['message' => 'Checkout successful', 'balance' => $balance, 'change' => $changeAmount]);
}
}
