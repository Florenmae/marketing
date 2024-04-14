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
    return Product::where('userId', 1)
                    ->where('status', 3)
                    ->get();
    }

    public function getOrders()
{
    return Order::whereIn('status', [2, 3])->get();
}

    public function getProdlist(){
    return ProductList::all();
    }

    public function addCart(Request $request){

    $customerId = Auth::id();
    $productId = $request->input('productId');
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

//     public function checkOutOrder(Request $request)
//     {

//     DB::beginTransaction();

//     try {
//         $products = $request->input('products');

//         foreach ($products as $productData) {
//             $id = $productData['id'];

//             $product = Product::findOrFail($id);

//             $originalStock = $product->stocks;

//             $subtractedQty = $productData['qty'];
//             $product->stocks -= $subtractedQty;

//             if ($product->stocks < 0) {
//                 $product->stocks = 0;
//             }

//             $product->userId = Auth::id();
//             $product->price;
//             $product->status = 4;

//             $product->save();

//             $transaction = new Transaction();
//             $transaction->productId = $product->id;
//             $transaction->userId = Auth::id();
//             $transaction->qty = $subtractedQty; 
//             $transaction->save();

//             $delivery = new Delivery();
//             $delivery->userId = Auth::id();
//             $delivery->transactionId = $transaction->id;
//             $delivery->productId = $product->id;
//             $delivery->qty = $subtractedQty; 
//             $delivery->status = 5;
//             $delivery->save();
//         }

//         DB::commit();
//         Cart::truncate();

//         return response()->json(['message' => 'Products submitted successfully'], 200);
//     } catch (\Exception $e) {
//         DB::rollback();
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }

// public function checkOutOrder(Request $request){
//     DB::beginTransaction();

//         $products = $request->input('products');

//         foreach ($products as $productData) {
//             $productId = $productData['productId'];

//             $product = Product::findOrFail($productId);
           
//             $originalStock = $product->stocks;

//             $subtractedQty = $productData['qty'];
//             $product->stocks -= $subtractedQty;

//             if ($product->stocks < 0) {
//                 $product->stocks = 0;
//             }

//             $product->price;
//             $product->status = 2;
            
//             $product->save();

//             $transaction = new Transaction();
//             $transaction->productId = $product->id;
//             $transaction->userId = Auth::id();
//             $transaction->qty = $subtractedQty; 
//             $transaction->save();

//             $delivery = new Delivery();
//             $delivery->userId = Auth::id();
//             $delivery->transactionId = $transaction->id;
//             $delivery->productId = $product->id;
//             $delivery->qty = $subtractedQty; 
//             $delivery->status = 3;
//             $delivery->save();
//         }

//         DB::commit();
//         Cart::truncate();
// }
    

public function checkOutOrder(Request $request)
{
    DB::beginTransaction();

    try {
        $products = $request->input('products');

        foreach ($products as $productData) {
            $productId = $productData['productId'];

            $product = Product::findOrFail($productId);

            // Save the product in the order table with status 2 (pending approval)
            $order = new Order();
            $order->productId = $product->id;
            $order->customerId = Auth::id(); // Assuming customer ID is stored in the order table
            $order->qty = $productData['qty'];
            $order->total = $product->price * $productData['qty'];
            $order->status = 2; // Status 2 indicates pending approval
            $order->save();

            // Create a transaction record
            $transaction = new Transaction();
            $transaction->productId = $product->id;
            $transaction->userId = Auth::id();
            $transaction->qty = $productData['qty'];
            $transaction->save();

            // Create a delivery record
            $delivery = new Delivery();
            $delivery->userId = Auth::id();
            $delivery->transactionId = $transaction->id;
            $delivery->productId = $product->id;
            $delivery->qty = $productData['qty'];
            $delivery->status = 3; // Status 3 indicates pending delivery
            $delivery->save();
        }

        // Commit the transaction if all operations succeed
        DB::commit();
        Cart::truncate(); // Empty the cart after successful checkout
        return response()->json(['message' => 'Checkout successful'], 200);
    } catch (\Exception $e) {
        // Rollback the transaction if an error occurs
        DB::rollback();
        return response()->json(['error' => 'An error occurred while processing the order'], 500);
    }
}


    

}
