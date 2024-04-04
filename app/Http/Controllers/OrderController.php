<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductList;
use App\Models\OrderProduct;
use App\Models\Transaction;
use App\Models\Delivery;
use App\Models\DeliveryCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function getProd(){
    return Product::where('status', 3)->get();
    }

    public function getProdlist(){
    return ProductList::all();
    }

    public function addCart(Request $request)
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

    public function checkOutOrder(Request $request){

    DB::beginTransaction();

    try {
        $products = $request->input('products');

        foreach ($products as $productData) {
            $id = $productData['id'];

            $product = Product::findOrFail($id);

            $originalStock = $product->stocks;

            $subtractedQty = $productData['qty'];
            $product->stocks -= $subtractedQty;

            if ($product->stocks < 0) {
                $product->stocks = 0;
            }

            $product->userId = Auth::id();
            $product->price;
            $product->status = 2;

            $product->save();

            $transaction = new Transaction();
            $transaction->productId = $product->id;
            $transaction->userId = Auth::id();
            $transaction->qty = $subtractedQty; 
            $transaction->save();

            $delivery = new Delivery();
            $delivery->userId = Auth::id();
            $delivery->transactionId = $transaction->id;
            $delivery->productId = $product->id;
            $delivery->qty = $subtractedQty; 
            $delivery->status = 3;
            $delivery->save();
        }

        DB::commit();
        Cart::truncate();

        return response()->json(['message' => 'Products submitted successfully'], 200);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    

}
