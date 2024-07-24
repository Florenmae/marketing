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
    
    return Order::whereIn('status', [2, 3]) 
                ->get();
}


    public function getProdlist(){
    return ProductList::all();
    }

//     public function addCart(Request $request){

//     $customerId = Auth::id();
//     $productId = $request->input('productId');
//     $qty = $request->input('qty', 1);

//     $cartItem = Cart::where('productId', $productId)
//                     ->where('customerId', $customerId) 
//                     ->first();

//     if ($cartItem) {
//         $cartItem->qty += $qty;
//         $cartItem->total = $cartItem->qty * $cartItem->price;
//         $cartItem->save();
//     } else {
        
//         Cart::create([
//             'productId' => $productId,
//             'customerId' => $customerId, 
//             'image' => $request->input('image'),
//             'price' => $request->input('price'),
//             'unit' => $request->input('unit'),
//             'description' => $request->input('description'),
//             'total' => $request->input('price') * $qty,
//             'qty' => $qty,
//         ]);
//     }
// }

public function addCart(Request $request)
{   
    $id = $request->input('id');
    $qty = $request->input('qty', 1);
    $customerId = Auth::id();
    $productlistId = $request->input('productlistId');

    $product = Product::find($id);

    $price = $product->price;

    $cartItem = Cart::where('productId', $id)
                            ->where('productlistId', $productlistId)
                            ->where('customerId', $customerId)
                            ->first();

    if ($cartItem) {
        $cartItem->qty += $qty;
        $cartItem->price = $product->price * $cartItem->qty;
        $cartItem->save();
    } else {
        Cart::create([
            'productId' => $id,
            'productlistId' => $productlistId,
            'customerId' => $customerId, 
            'image' => $request->input('image'),
            'price' => $product->price,
            'unit' => $request->input('unit'),
            'description' => $request->input('description'),
            'total' => $product->price * $qty,
            'qty' => $qty,
        ]);
    }

    return ;
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

    $products = $request->input('products');

    foreach ($products as $productData) {
        $productId = $productData['productId'];

        $product = Product::findOrFail($productId);
        
        $price = $product->price;

        $order = new Order();
        $order->productId = $product->id;        
        $order->productlistId = $product->productlistId;        
        $order->userId = Auth::id(); 
        $order->customerId = Auth::id(); 
        $order->qty = $productData['qty'];
        $order->price = $price;
        //$order->description = $description;
        $order->total = $price * $productData['qty'];
        $order->status = 2; 
        $order->save();

        $transaction = new Transaction();
        $transaction->productId = $product->id;
        $transaction->userId = Auth::id();
        $transaction->type = 2;
        $transaction->qty = $productData['qty'];
        $transaction->totalprice = $price * $productData['qty'];
        $transaction->save();

        $transactionId = $transaction->id;

        $order->transactionId = $transactionId;
        $order->save();

        $delivery = new Delivery();
        $delivery->userId = Auth::id();
        $delivery->transactionId = $transactionId;
        $delivery->productId = $product->id;
        $delivery->qty = $productData['qty'];
        $delivery->status = 3; 
        $delivery->save();
    }

    DB::commit();
    Cart::truncate(); 
    return response()->json(['message' => 'Checkout successful'], 200);
    }


    public function approveOrder(Request $request)
    {
        $id = $request->editingOrderId;
        $order = Order::findOrFail($id);

        $order->status = $request->prodPayload["status"];
        $order->approved_by = $request->prodPayload["approved_by"];

        $order->save();

        return $order;

    }

    public function rejectOrder(Request $request, $id)
    {
        $order = Order::find($id);

        $order->status = 4; 

        $order->save();

        return response()->json(['success' => true, 'message' => 'Order rejected successfully']);
    }

}
