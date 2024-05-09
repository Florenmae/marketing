<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\ProductList; 
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Categories;
use App\Models\OrderProduct;
use App\Models\ReturnedProduct;
use App\Models\CashRegistry;
use Carbon\Carbon;
use Auth;

class PosController extends Controller{
   
    public function fetchProducts()
{
    // $userId = Auth::id();

    $products = Product::where('userId', 1)
                        ->where('status', 3)
                        ->where('stocks','>', 0)
                        ->get();

    return $products;
}

    public function fetchProductLists()
{
    return ProductList::all();
}

    public function fetchCategories(){
        return Categories::all();
    }

   public function addToCart(Request $request)
{
    $productId = $request->input('productId');
    $customerId = $request->input('customerId');
    $qty = $request->input('qty', 1);
    
    $product = Product::find($productId);
    // dd($product);
    $cartItem = Cart::where('productId', $productId)
                    ->where('customerId', $customerId) 
                    ->first();

    if ($cartItem) {
        $cartItem->qty += $qty;
        $cartItem->total = $cartItem->qty * $product->price;
        $cartItem->save();
    } else {
        Cart::create([
            'productId' => $productId,
            'customerId' => $customerId, 
            'image' => $request->input('image'),
            'price' => $product->price ,
            'unit' => $request->input('unit'),
            'description' => $request->input('description'),
            'total' => $product->price * $qty,
            'qty' => $qty,
        ]);
    }
}

//     public function addToCart(Request $request)
// {
//     $id = $request->input('id');
//     $userId = 1; 
//     $customerId = $request->input('customerId');
//     $qty = $request->input('qty', 1);
    
//     $user = User::find($userId);
//     if ($user) {
//         $product = $user->products()->find($id);
        
//         if ($product) {
//             $cartItem = Cart::where('id', $id)
//                             ->where('customerId', $customerId) 
//                             ->first();

//             if ($cartItem) {
//                 $cartItem->qty += $qty;
//                 $cartItem->total = $cartItem->qty * $product->price;
//                 $cartItem->save();
//             } else {
//                 Cart::create([
//                     'id' => $id,
//                     'customerId' => $customerId, 
//                     'userId' => $userId,
//                     'image' => $product->image, 
//                     'price' => $product->price,
//                     'unit' => $product->unit, 
//                     'description' => $product->description, 
//                     'total' => $product->price * $qty,
//                     'qty' => $qty,
//                 ]);
//             }
//         } else {
            
//             return response()->json(['error' => 'Product is not associated with the user'], 404);
//         }
//     } else {
       
//         return response()->json(['error' => 'User with ID 1 not found'], 404);
//     }
// }



    public function showCartItem(Request $request){
        return Cart::all();
    }

    public function deleteItem(Request $request){
        $deleteItem = Cart::find($request->id);

        $res = $deleteItem->delete();
        return $res;
    }


// public function checkout(Request $request)
// {
//     $cartItems = Cart::all();
//     $totalAmount = 0;

//     foreach ($cartItems as $cartItem) {
//         $totalAmount += $cartItem->total;
//     }

//     $paymentMethod = $request->input('paymentMethod');
//     $amountGiven = $request->input('amountGiven');

//     if ($amountGiven >= $totalAmount) {
//         $balance = 0;
//         $changeAmount = $amountGiven - $totalAmount;
//     } else {
//         $balance = $totalAmount - $amountGiven;
//         $changeAmount = 0;
//     }

//     foreach ($cartItems as $cartItem) {
//         $product = Product::find($cartItem->productId);
//         if ($product) {
//             $newStock = $product->stocks - $cartItem->qty;
            
//             $product->stocks = max(0, $newStock);
//             $product->save();
//         }
//     }

//     $orderItems = [];
//     $now = now();

//     foreach ($cartItems as $cartItem) {
//         $orderItems[] = [
//             'productId' => $cartItem->productId,
//             'customerId' => $cartItem->customerId,
//             'price' => $cartItem->price,
//             'qty' => $cartItem->qty,
//             'total' => $cartItem->total,
//             'description' => $cartItem->description,
//             'image' => $cartItem->image,
//             'paymentMethod' => $paymentMethod,
//             'balance' => $balance,
//             'changeAmount' => $changeAmount,
//             'created_at' => $now,
//             'updated_at' => $now,
//         ];
//     }

//     $orderProduct = new Order();
//     $orderProduct->insert($orderItems);

//     Cart::truncate();

//     return response()->json(['message' => 'Checkout successful', 'balance' => $balance, 'change' => $changeAmount]);
// }

// public function checkout(Request $request)
// {
//     $cartItems = Cart::all();
//     $totalAmount = 0;

//     foreach ($cartItems as $cartItem) {
//         $totalAmount += $cartItem->total;
//     }

//     $paymentMethod = $request->input('paymentMethod');
//     $amountGiven = $request->input('amountGiven');

//     if ($amountGiven >= $totalAmount) {
//         $balance = 0;
//         $changeAmount = $amountGiven - $totalAmount;
//     } else {
//         $balance = $totalAmount - $amountGiven;
//         $changeAmount = 0;
//     }

//     foreach ($cartItems as $cartItem) {
//     $product = Product::find($cartItem->productId);
    
//     if ($product && $cartItem->userId == 1) {
//         $product->stocks -= $cartItem->qty;
//         $product->save();
//     }
// }
//     $orderItems = [];
//     $now = now();

//     foreach ($cartItems as $cartItem) {
//         $orderItems[] = [
//             'productId' => $cartItem->productId,
//             'customerId' => $cartItem->customerId,
//             'price' => $cartItem->price,
//             'qty' => $cartItem->qty,
//             'total' => $cartItem->total,
//             'paymentMethod' => $paymentMethod,
//             'balance' => $balance,
//             'changeAmount' => $changeAmount,
//             'status' => 3,
//             'created_at' => $now,
//             'updated_at' => $now,
//         ];
//     }

//     $orderProduct = new Order();
//     $orderProduct->insert($orderItems);

//     Cart::truncate();

//     return response()->json(['message' => 'Checkout successful', 'balance' => $balance, 'change' => $changeAmount]);
// }

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

    
    $lastCashReg = CashRegistry::latest()->first();

    if ($lastCashReg) {
        
        $updatedCashOnHand = $lastCashReg->cashOnHand + $totalAmount;

        $cashReg = new CashRegistry();
        $cashReg->cashOnHand = $updatedCashOnHand;
        $cashReg->save();
    }

    foreach ($cartItems as $cartItem) {
        $product = Product::find($cartItem->productId);
    
        if ($product && $cartItem->userId == 1) {
            $product->stocks -= $cartItem->qty;
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
            'paymentMethod' => $paymentMethod,
            'balance' => $balance,
            'changeAmount' => $changeAmount,
            'status' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    $orderProduct = new Order();
    $orderProduct->insert($orderItems);

    Cart::truncate();

    return response()->json(['message' => 'Checkout successful', 'balance' => $balance, 'change' => $changeAmount]);
}




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
                'created_at' => Carbon::parse($order->created_at)->format('F d, Y'),
                'updated_at' => Carbon::parse($order->updated_at)->format('F d, Y'),
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
