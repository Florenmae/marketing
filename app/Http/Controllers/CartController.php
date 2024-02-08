<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
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


}
