<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Inventory;
use App\Models\Delivery;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ProductUserController extends Controller
{

    public function getInventories()
    {
        $user = Auth::user();
        $inventories = $user->inventories;

        return $inventories;
    }

//     public function SubmitAdmin(Request $request){
//     $product = Product :: findOrFail($request->editingProductId);

//     $product->name = $request->prodPayload["name"];
//     $product->userId = $request->prodPayload["userId"];
//     $product->categoryId = $request->prodPayload["categoryId"];
//     $product->item_code = $request->prodPayload["item_code"];
//     $product->price = $request->prodPayload["price"];
//     $product->unit = $request->prodPayload["unit"];
//     $product->stocks = $request->prodPayload["stocks"];
//     $product->status = 2;
//     $product->description = $request->prodPayload["description"]; 

//     $product->save();

//     return $product;
// }

public function SubmitAdmin(Request $request){
    $product = Inventory::findOrFail($request->editingInventoryId);

    $requestedQuantity = $request->prodPayload["stocks"];
    $remainingStocks = max(0, $product->stocks - $requestedQuantity);
   
    $product->name = $request->prodPayload["name"];
    $product->userId = Auth::id();
    $product->categoryId = $request->prodPayload["categoryId"];
    $product->item_code = $request->prodPayload["item_code"];
    $product->price = $request->prodPayload["price"];
    $product->unit = $request->prodPayload["unit"];
    $product->stocks = $remainingStocks; 
    $product->status = 2;
    $product->description = $request->prodPayload["description"]; 

    if ($product->status == 2) { 
        
        $transaction = Transaction::where('productId', $product->id)->first();

        if ($transaction) {
            $delivery = new Delivery();
            $delivery->userId = Auth::id();
            $delivery->transactionId = $transaction->id; 
            $delivery->remarks = $request->prodPayload["remarks"];

            $delivery->status = 2; 
            $delivery->save();
        }
    }

    $product->save();


    return $product;
}




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
//             $delivery->remarks = $request->prodPayload["remarks"];

//             $delivery->status = 4; 
//             $delivery->save();
//         }
//     }

//     $product->save();

//     return $product;
// }


    public function getCategories()
        {
            return Categories::all();

        }


}
