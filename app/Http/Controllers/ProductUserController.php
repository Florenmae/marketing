<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
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

    public function SubmitAdmin(Request $request){
    $product = Product :: findOrFail($request->editingProductId);

    // $product->productId = $request->prodPayload["name"];
    $product->userId = $request->prodPayload["userId"];
    $product->categoryId = $request->prodPayload["categoryId"];
    $product->item_code = $request->prodPayload["item_code"];
    $product->price = $request->prodPayload["price"];
    $product->unit = $request->prodPayload["unit"];
    $product->stocks = $request->prodPayload["stocks"];
    $product->status = 2; 
    $product->description = $request->prodPayload["description"]; 
    $product->approved_by = $request->prodPayload["approved_by"];

    $product->save();

    return $product;
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


}
