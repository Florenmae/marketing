<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\DeliveryCart;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ProductUserController extends Controller
{

    public function getProductsUser()
    {
        $user = Auth::user();
        $products = $user->products;

        return $products;
    }

//     public function SubmitAdmin(Request $request){
//     $product = Product :: findOrFail($request->editingProductId);

//     $product->productId = $request->prodPayload["name"];
//     $product->userId = $request->prodPayload["userId"];
//     $product->categoryId = $request->prodPayload["categoryId"];
//     $product->item_code = $request->prodPayload["item_code"];
//     $product->price = $request->prodPayload["price"];
//     $product->unit = $request->prodPayload["unit"];
//     $product->stocks = $request->prodPayload["stocks"];
//     $product->status = 2; 
//     $product->description = $request->prodPayload["description"]; 
//     $product->approved_by = $request->prodPayload["approved_by"];

//     $product->save();

//     return $product;
// }
public function submitAdmin(Request $request)
{
        // Assuming 'products' is the key used to send the array of products from the frontend
        $products = $request->input('products');

        // Loop through each product in the array
        foreach ($products as $productData) {
            // Assuming 'productId' is the key used to send the product ID from the frontend
            $productId = $productData['productId'];

            // Find the product by ID
            $product = Product::findOrFail($productId);

             $product->stocks -= $productData['qty'];

            // Ensure that the available stock doesn't go below 0
            if ($product->stocks < 0) {
                $product->stocks = 0;
            }

            // Update the product attributes
            // $product->productId = $productData['productId']; // No need to update productId
            // $product->categoryId = $productData['categoryId']; // Assuming categoryId remains the same
            // $product->userId = $productData['userId']; // Assuming userId remains the same
            // $product->image = $productData['image']; // Assuming image remains the same
            $product->price = $productData['price'];
            $product->qty = $productData['qty'];
            // $product->description = $productData['description']; // Assuming description remains the same
            $product->status = 2; // Change the status to 2

            // Save the updated product
            $product->save();
        }
}


public function Deliver(Request $request) {
    $product = Product::findOrFail($request->editingProductId);

    $product->name = $request->prodPayload["name"];
    $product->userId = $request->prodPayload["userId"];
    $product->categoryId = $request->prodPayload["categoryId"];
    $product->item_code = $request->prodPayload["item_code"];
    $product->price = $request->prodPayload["price"];
    $product->unit = $request->prodPayload["unit"];
    $product->stocks = $request->prodPayload["stocks"];
    $product->description = $request->prodPayload["description"];
    $product->status = 4;
    $product->approved_by = $request->prodPayload["approved_by"];

    if ($product->status == 4) { 
        
        $transaction = Transaction::where('productId', $product->id)->first();

        if ($transaction) {
            $delivery = new Delivery();
            $delivery->userId = Auth::id();
            $delivery->transactionId = $transaction->id; 
            $delivery->remarks = $transaction->remarks;
            $delivery->status = 4; 
            $delivery->save();
        }
    }

    $product->save();

    return $product;
}


    public function getCategories()
        {
            return Categories::all();

        }

     public function addToDevCart(Request $request)
{
    $productId = $request->input('productId');
    $qty = $request->input('qty', 1);

    $cartItem = DeliveryCart::where('productId', $request->input('productId'))
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
