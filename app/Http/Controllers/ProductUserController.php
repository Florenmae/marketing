<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\DeliveryCart;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProductUserController extends Controller
{

    public function getProductsUser()
    {
        $user = Auth::user();
        $products = $user->products;

        return $products;
    }

public function submitAdmin(Request $request)
{
    try {
        DB::beginTransaction();

        $products = $request->input('products');

        foreach ($products as $productData) {
            $productId = $productData['productId'];

            $product = Product::findOrFail($productId);

            $originalStock = $product->stocks;

            $subtractedQty = $productData['qty'];
            $product->stocks -= $subtractedQty;

            if ($product->stocks < 0) {
                $product->stocks = 0;
            }

            $product->price;
            $product->status = 2;

            $product->save();

            // $adminProduct = $product->replicate();
            // $adminProduct->userId = 1;
            // $adminProduct->stocks = $subtractedQty;
            // $adminProduct->save();
            
            // if ($adminProduct->stocks < 0) {
            //     $adminProduct->stocks = 0;
            // }

            // $adminProduct->save();

            // $adminProduct = Product::where('userId', 1) // Assuming admin user ID is 1
            //                         ->where('productId', $productId)
            //                         ->first();

            // if ($adminProduct) {
            //     $adminProduct->stocks += $subtractedQty;
            // } else {
            //     $adminProduct = $product->replicate();
            //     $adminProduct->userId = 1; 
            //     $adminProduct->stocks = $subtractedQty;
            // }

            // $adminProduct->save();
            

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
        DeliveryCart::truncate();

        return response()->json(['message' => 'Products submitted successfully to admin'], 200);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['error' => 'Failed to submit products to admin', 'message' => $e->getMessage()], 500);
    }
}


    public function getCategories()
        {
            return Categories::all();

        }

     public function addToDevCart(Request $request)
{
    $productId = $request->input('productId');
    // $deliveryId = $request->input('deliveryId');
    $qty = $request->input('qty', 1);

    $cartItem = DeliveryCart::where('productId', $request->input('productId'))
                    // ->where('deliveryId', $request->input('deliveryId'))
                    ->where('price', $request->input('price'))
                    ->first();

    if ($cartItem) {
        $cartItem->qty += $qty;
        $cartItem->price = $cartItem->qty * $cartItem->price;
        $cartItem->save();
    } else {
        DeliveryCart::create([
            
            'productId' => $productId,
            'price' => $request->input('price') * $qty,
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
        return DeliveryCart::all();
    }

    public function deleteItem(Request $request){
        $deleteItem = DeliveryCart::find($request->id);

        $res = $deleteItem->delete();
        return $res;
    }

    public function checkout(Request $request)
{
    $cartItems = DeliveryCart::all();
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

    DeliveryCart::truncate();

    return response()->json(['message' => 'Checkout successful', 'balance' => $balance, 'change' => $changeAmount]);
}

}
