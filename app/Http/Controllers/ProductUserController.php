<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\DeliveryCart;
use App\Models\Transaction;
use App\Models\ProductList;
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

    //  public function getProductLists()
    // {
    //     $user = Auth::user();
    //     $productLists = $user->productLists;

    //     return $productLists;
    // }

// public function submitAdmin(Request $request)
// {
//         DB::beginTransaction();

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
//         DeliveryCart::truncate();

// }

public function submitAdmin(Request $request){
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
}

    public function getCategories()
        {
            return Categories::all();

        }

    public function addToDevCart(Request $request)
{   

    $productId = $request->input('productId');
    $qty = $request->input('qty', 1);

    $cartItem = DeliveryCart::where('productId', $productId)->first();

    if ($cartItem) {
        
        $cartItem->qty += $qty;
        
        $product = Product::find($productId);

        $cartItem->price = $product->price * $cartItem->qty;
        $cartItem->save();
    } else {
        
        $product = Product::find($productId);
    
        DeliveryCart::create([
            'productId' => $productId,
            'price' => $product->price * $qty,
            'qty' => $qty,
        ]);
    }
}


    public function showCartItems(Request $request){
        return DeliveryCart::all();
        // dd(DeliveryCart::all());
    }

    public function deleteItem(Request $request){
        $deleteItem = DeliveryCart::find($request->id);

        $res = $deleteItem->delete();
        return $res;
    }

}
