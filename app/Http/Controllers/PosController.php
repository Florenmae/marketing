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
use App\Models\Transaction;
use App\Models\CashRegistry;
use App\Models\CashLogs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
    

class PosController extends Controller{
   
   public function fetchProducts(Request $request)
{
    $userId = Auth::id();
    $search = $request->input('search');

    $query = Product::join('product_lists', 'products.productlistId', '=', 'product_lists.id')
                    ->where('products.status', 3)
                    ->where('products.userId', $userId)
                    ->where('products.stocks', '>', 0);

    if ($search) {
        $query->where(function ($query) use ($search) {
            $query->Where('products.description', 'like', '%' . $search . '%')
                  ->orWhere('product_lists.name', 'like', '%' . $search . '%');
        });
    }

    $products = $query->select('products.*', 'product_lists.name as product_list_name')->get();

    return response()->json($products);
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
    $id = $request->input('id');
    $qty = $request->input('qty', 1);
    $customerId = $request->input('customerId');
    $productlistId = $request->input('productlistId');

    $product = Product::find($id);
    $price = $product->price;

    $cartItem = Cart::where('productId', $id)
                            ->where('productlistId', $productlistId)
                            ->where('customerId', $customerId)
                            ->first();

    if ($cartItem) {
        $cartItem->qty += $qty;
        $cartItem->total = $product->price * $cartItem->qty;
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
    $totalAmount = $cartItems->sum('total');
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

        $updatedCashOnHand = $lastCashReg->amount + $amountGiven - $changeAmount;
        $lastCashReg->amount = $updatedCashOnHand;
        $lastCashReg->save();

        
        $cashLog = new CashLogs();
        $cashLog->inflow = $amountGiven;
        $cashLog->outflow = $changeAmount;

        $transaction = Transaction::latest()->first();
        if ($transaction) {
            $cashLog->transactionId = $transaction->id;
        }
        
        $cashLog->save();
    }

    foreach ($cartItems as $cartItem) {
        $product = Product::find($cartItem->productlistId);
        if ($product && $cartItem->userId == 1) {
            $product->decrement('stocks', $cartItem->qty);
        }
    }

   
    $orderItems = [];
    $now = now();
    foreach ($cartItems as $cartItem) {
        $orderItems[] = [
            'productlistId' => $cartItem->productlistId,
            'transactionId' => $cartItem->transactionId,
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

      
        $transaction = new Transaction();
        $transaction->productId = $cartItem->productId;
        $transaction->productlistId = $cartItem->productlistId;
        $transaction->userId = Auth::id();
        $transaction->qty = $cartItem->qty;
        $transaction->actualQty = $cartItem->qty;
        $transaction->type = 2; 
        $transaction->roleId = $cartItem->customerId;
        $transaction->amountGiven = $amountGiven; 
        $transaction->balance = $balance; 
        $transaction->totalprice = $cartItem->total; 
        $transaction->changeAmount = $changeAmount;
        $transaction->save();
    }

  
    Order::insert($orderItems);

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
