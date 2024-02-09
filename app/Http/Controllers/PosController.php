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
    $quantity = $request->input('quantity', 1);

    $cartItem = Cart::where('product_id', $productId)->first();

    if ($cartItem) {
        $cartItem->quantity += $quantity;
        $cartItem->total = $cartItem->quantity * $cartItem->price;
        $cartItem->save();
    } else {
        Cart::create([
            'product_id' => $productId,
            'name' => $request->input('name'),
            'image' => $request->input('image'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'total' => $request->input('price') * $quantity,
            'quantity' => $quantity,
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

    $orderItems = [];
    $now = Carbon::now();
    foreach ($cartItems as $cartItem) {
        $orderItems[] = [
            'product_id' => $cartItem->product_id,
            'name' => $cartItem->name,
            'price' => $cartItem->price,
            'quantity' => $cartItem->quantity,
            'total' => $cartItem->total,
            'description' => $cartItem->description,
            'image' => $cartItem->image,
            'created_at' => $now->toDateTimeString(),
            'updated_at' => $now->toDateTimeString(),
        ];
    }

    $orderProduct = new OrderProduct();

    $orderProduct->insert($orderItems);

    Cart::truncate();

    return response()->json(['message' => 'Checkout successful']);
}
}
