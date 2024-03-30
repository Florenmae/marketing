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
use Auth;

class PosController extends Controller
{
   public function fetchProducts()
{
    $userId = Auth::id();

    $products = Product::where('userId', $userId)
                        ->where('status', 3)
                        ->get();

    return $products;
}

    public function fetchCategories(){
        return Categories::all();
    }

   public function addToCart(Request $request)
{
    $productId = $request->input('productId');
    $customerId = $request->input('customerId');
    $qty = $request->input('qty', 1);

    $cartItem = Cart::where('productId', $productId)
                    ->where('customerId', $customerId) 
                    ->first();

    if ($cartItem) {
        $cartItem->qty += $qty;
        $cartItem->total = $cartItem->qty * $cartItem->price;
        $cartItem->save();
    } else {
        
        Cart::create([
            'productId' => $productId,
            'customerId' => $customerId, 
            'image' => $request->input('image'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'description' => $request->input('description'),
            'total' => $request->input('price') * $qty,
            'qty' => $qty,
        ]);
    }
}

    public function showCartItem(Request $request){
        return Cart::all();
    }

    public function deleteItem(Request $request){
        $deleteItem = Cart::find($request->id);

        $res = $deleteItem->delete();
        return $res;
    }
use App\Models\Product;

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

    // Update product stocks and deduct quantities
    foreach ($cartItems as $cartItem) {
        $product = Product::find($cartItem->productId);
        if ($product) {
            $newStock = $product->stocks - $cartItem->qty;
            // Make sure stock doesn't go negative
            $product->stocks = max(0, $newStock);
            $product->save();
        }
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

    $orderProduct = new Order();
    $orderProduct->insert($orderItems);

    Cart::truncate();

    return response()->json(['message' => 'Checkout successful', 'balance' => $balance, 'change' => $changeAmount]);
}

}
