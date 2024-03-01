<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
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

    $product->name = $request->prodPayload["name"];
    $product->userId = $request->prodPayload["userId"];
    $product->categoryId = $request->prodPayload["categoryId"];
    $product->item_code = $request->prodPayload["item_code"];
    $product->price = $request->prodPayload["price"];
    $product->unit = $request->prodPayload["unit"];
    $product->stocks = $request->prodPayload["stocks"];
    $product->description = $request->prodPayload["description"];
    $product->status = 2; 
    $product->approved_by = $request->prodPayload["approved_by"];


    if ($product->status == 3) {

        $transaction = new Transaction();
        $transaction->productId = $product->id;
        $transaction->userId = $product->userId;
        $transaction->type= $product->type;
        $transaction->qty = $product->stocks;
        $transaction->stocks = $product->stocks;
        $transaction->approved_by = $request->prodPayload["approved_by"];

        $transaction->save();
    }

    $product->save();

    return $product;
}

    public function getCategories()
        {
            return Categories::all();

        }


}
