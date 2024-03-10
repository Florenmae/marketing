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
// public function submitAdmin(Request $request)
// {
//         // Assuming 'products' is the key used to send the array of products from the frontend
//         $products = $request->input('products');

//         // Loop through each product in the array
//         foreach ($products as $productData) {
//             // Assuming 'productId' is the key used to send the product ID from the frontend
//             $productId = $productData['productId'];

//             // Find the product by ID
//             $product = Product::findOrFail($productId);

//              $product->stocks -= $productData['qty'];

//             // Ensure that the available stock doesn't go below 0
//             if ($product->stocks < 0) {
//                 $product->stocks = 0;
//             }

//             // Update the product attributes
//             // $product->productId = $productData['productId']; // No need to update productId
//             // $product->categoryId = $productData['categoryId']; // Assuming categoryId remains the same
//             // $product->userId = $productData['userId']; // Assuming userId remains the same
//             // $product->image = $productData['image']; // Assuming image remains the same
//             $product->price = $productData['price'];
//             $product->qty = $productData['qty'];
//             // $product->description = $productData['description']; // Assuming description remains the same
//             $product->status = 2; // Change the status to 2

//             // Save the updated product
//             $product->save();
//         }
// }


// public function Deliver(Request $request) {
//     $product = Product::findOrFail($request->editingProductId);

//     $product->name = $request->prodPayload["name"];
//     $product->userId = $request->prodPayload["userId"];
//     $product->categoryId = $request->prodPayload["categoryId"];
//     $product->item_code = $request->prodPayload["item_code"];
//     $product->price = $request->prodPayload["price"];
//     $product->unit = $request->prodPayload["unit"];
//     $product->stocks = $request->prodPayload["stocks"];
//     $product->description = $request->prodPayload["description"];
//     $product->status = 4;
//     $product->approved_by = $request->prodPayload["approved_by"];

//     if ($product->status == 4) { 
        
//         $transaction = Transaction::where('productId', $product->id)->first();

//         if ($transaction) {
//             $delivery = new Delivery();
//             $delivery->userId = Auth::id();
//             $delivery->transactionId = $transaction->id; 
//             $delivery->remarks = $transaction->remarks;
//             $delivery->status = 4; 
//             $delivery->save();
//         }
//     }

//     $product->save();

//     return $product;
// }

// public function submitAdmin(Request $request)
// {
//     try {
//         // Start a transaction
//         DB::beginTransaction();

//         // Assuming 'products' is the key used to send the array of products from the frontend
//         $products = $request->input('products');

//         // Loop through each product in the array
//         foreach ($products as $productData) {
//             // Assuming 'productId' is the key used to send the product ID from the frontend
//             $productId = $productData['productId'];

//             // Find the product by ID
//             $product = Product::findOrFail($productId);

//             // Subtract the quantity added to the delivery cart from the available stock
//             $product->stocks -= $productData['qty'];

//             // Ensure that the available stock doesn't go below 0
//             if ($product->stocks < 0) {
//                 $product->stocks = 0;
//             }

//             // Update the product attributes
//             // $product->productId = $productData['productId']; // No need to update productId
//             // $product->categoryId = $productData['categoryId']; // Assuming categoryId remains the same
//             // $product->userId = $productData['userId']; // Assuming userId remains the same
//             // $product->image = $productData['image']; // Assuming image remains the same
//             $product->price = $productData['price'];
//             $product->qty = $productData['qty'];
//             // $product->description = $productData['description']; // Assuming description remains the same
//             $product->status = 2; // Change the status to 2

//             // Save the updated product
//             $product->save();

//             // Create a transaction
//             $transaction = new Transaction();
//             $transaction->productId = $product->id;
//             // Assuming other transaction-related data needs to be filled, such as user ID, payment method, etc.
//             // $transaction->userId = $productData['userId'];
//             // $transaction->paymentMethod = ...;
//             $transaction->save();

//             // Create a delivery record
//             $delivery = new Delivery();
//             $delivery->userId = Auth::id();
//             $delivery->transactionId = $transaction->id;
//             // Assuming other delivery-related data needs to be filled
//             // $delivery->remarks = ...;
//             $delivery->status = 3;
//             $delivery->save();
//         }

//         // Commit the transaction
//         DB::commit();

//         // Return a success response
//         return response()->json(['message' => 'Products submitted successfully to admin'], 200);
//     } catch (\Exception $e) {
//         // Rollback the transaction in case of an error
//         DB::rollback();

//         // Return an error response if something goes wrong
//         return response()->json(['error' => 'Failed to submit products to admin', 'message' => $e->getMessage()], 500);
//     }
// }

public function submitAdmin(Request $request)
{
    try {
        DB::beginTransaction();

        $products = $request->input('products');

        foreach ($products as $productData) {
            $productId = $productData['productId'];

            $product = Product::findOrFail($productId);

            // Store the original stock before subtracting
            $originalStock = $product->stocks;

            // Subtract the quantity from the available stock
            $subtractedQty = $productData['qty'];
            $product->stocks -= $subtractedQty;

            if ($product->stocks < 0) {
                $product->stocks = 0;
            }

            $product->price = $productData['price'];
            $product->status = 2; 

            $product->save();

            // Saving transaction details
            $transaction = new Transaction();
            $transaction->productId = $product->id;
            $transaction->userId = Auth::id();
            $transaction->qty = $subtractedQty; 
            $transaction->save();

            // Saving delivery details
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
