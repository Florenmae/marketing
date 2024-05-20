<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductList;
use App\Models\User;
use App\Models\Role;
use App\Models\Categories;
use App\Models\Delivery;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ReturnedProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller{

//     public function updateProduct(Request $request){
//         DB::beginTransaction();

//         $productId = $request->editingProductId;
//         $product = Product::findOrFail($productId);

//         $product->userId = $request->prodPayload["userId"];
//         $product->categoryId = $request->prodPayload["categoryId"];
//         $product->item_code = $request->prodPayload["item_code"];
//         $product->price = $request->prodPayload["price"];
//         $product->unit = $request->prodPayload["unit"];
//         $product->description = $request->prodPayload["description"];
//         $product->status = $request->prodPayload["status"];
//         $product->approved_by = $request->prodPayload["approved_by"];

//         if ($product->status == 3) {
//             $actualQty = $request->prodPayload["actualQty"];

//             $transaction = new Transaction();
//             $transaction->productId = $product->id;
//             $transaction->userId = Auth::id();
//             $transaction->type = $request->prodPayload["type"];
//             // $transaction->qty = $qty; 
//             $transaction->actualQty = $actualQty;

//             $product->stocks -= $actualQty;
//             $transaction->stocks = $product->stocks;

//             $transaction->save();
//         }

//         $adminProduct = Product::where('userId', 1)
//                                 ->where('productId', $productId)
//                                 ->first();

//         if ($adminProduct) {
//             $adminProduct->stocks += $request->prodPayload["actualQty"];
//             $adminProduct->save();
//         } else {
//             $adminProduct = $product->replicate();
//             $adminProduct->userId = 1; 
//             $adminProduct->stocks = $request->prodPayload["actualQty"];
//             $adminProduct->save();
//         }


//         $product->save();

//         DB::commit();

//         return $product;
// }

//     public function approveProduct(Request $request) {
//     DB::beginTransaction();

//     try {
//         // Find and update the original product
//         $productId = $request->editingProductId;
//         $product = Product::findOrFail($productId);

//         $product->userId = $request->prodPayload["userId"];
//         $product->categoryId = $request->prodPayload["categoryId"];
//         $product->item_code = $request->prodPayload["item_code"];
//         $product->price = $request->prodPayload["price"];
//         $product->unit = $request->prodPayload["unit"];
//         $product->description = $request->prodPayload["description"];
//         $product->status = 3; 
//         $product->approved_by = $request->prodPayload["approved_by"];
//         $product->save();

//         // Handle product stocks
//         $actualQty = $request->prodPayload["actualQty"];
        
//         $transaction = Transaction::where('productId', $product->id)->first();
//         if ($transaction) {
//             $transaction->qty = -$actualQty;
//             $transaction->actualQty = $actualQty;
//             $transaction->stocks = $product->stocks - $actualQty;
//             $transaction->save();
//         } else {
//             $transaction = new Transaction();
//             $transaction->productId = $product->id;
//             $transaction->userId = Auth::id();
//             $transaction->type = $request->prodPayload["type"];
//             $transaction->qty = -$actualQty;
//             $transaction->actualQty = $actualQty;
//             $transaction->stocks = $product->stocks - $actualQty;
//             $transaction->save();
//         }

//         $product->stocks -= $actualQty;

//         // Check if a product with userId 1 exists
//         $adminProduct = Product::where('productlistId', $product->productlistId)
//                                ->where('userId', 1)
//                                ->first();

//         if ($adminProduct) {
//             // If the product exists, update the stock
//             $adminProduct->stocks += $actualQty;
//             $adminProduct->save();
//         } else {
//             // If the product doesn't exist, create a new product
//             $adminProduct = new Product();
//             $adminProduct->userId = 1;
//             $adminProduct->categoryId = $product->categoryId;
//             $adminProduct->productlistId = $product->productlistId;
//             $adminProduct->item_code = $product->item_code;
//             $adminProduct->price = $product->price;
//             $adminProduct->image = $product->image;
//             $adminProduct->unit = $product->unit;
//             $adminProduct->stocks = $actualQty;
//             $adminProduct->description = $product->description;
//             $adminProduct->status = 3; 
//             $adminProduct->approved_by = $product->approved_by;
//             $adminProduct->save();
//         }

//         DB::commit();

//         return response()->json(['success' => true]);
//     } catch (\Exception $e) {
//         DB::rollback();
//         return response()->json(['success' => false, 'message' => $e->getMessage()]);
//     }
// }


    public function approveProduct(Request $request){

    DB::beginTransaction();

    try {
        $productId = $request->editingProductId;
        $product = Product::findOrFail($productId);

        $product->userId = $request->prodPayload["userId"];
        $product->categoryId = $request->prodPayload["categoryId"];
        $product->item_code = $request->prodPayload["item_code"];
        $product->price = $request->prodPayload["price"];
        $product->unit = $request->prodPayload["unit"];
        $product->description = $request->prodPayload["description"];
        $product->status = 3; 
        $product->approved_by = $request->prodPayload["approved_by"];
        $product->save();

        if ($product->status == 3) {
            $actualQty = $request->prodPayload["actualQty"];

            $transaction = Transaction::where('productId', $product->id)->first();
            if ($transaction) {
                $transaction->qty = -$actualQty;
                $transaction->actualQty = $actualQty;
                $transaction->stocks = $product->stocks - $actualQty; 
                $transaction->save();
            } else {
                
                $transaction = new Transaction();
                $transaction->productId = $product->id;
                $transaction->userId = Auth::id();
                $transaction->type = $request->prodPayload["type"];
                $transaction->qty = -$actualQty;
                $transaction->actualQty = $actualQty;
                $transaction->stocks = $product->stocks - $actualQty;
                $transaction->save();
            }

            $product->stocks -= $actualQty;
        }

        $adminProduct = new Product();
        $adminProduct->userId = 1;
        $adminProduct->categoryId = $product->categoryId;
        $adminProduct->productlistId = $product->productlistId;
        $adminProduct->item_code = $product->item_code;
        $adminProduct->price = $product->price;
        $adminProduct->image = $product->image;
        $adminProduct->unit = $product->unit;
        $adminProduct->stocks = $actualQty;
        $adminProduct->description = $product->description;
        $adminProduct->status = 3; 
        $adminProduct->approved_by = $product->approved_by;
        $adminProduct->save();

        DB::commit();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

    public function getCategories()
    {
        return Categories::all();

    }

    public function getProducts()
    {
        return Product::all();
    }

    public function fetchDeliveries()
    {
        return Delivery::all();
    }

    public function getProductLists()
    {
        return ProductList::all();
    }

    public function getUsers()
    {
         return User::all();

    }

    public function getOrders()
    {
        return Order::whereIn('status', [2, 3])->get();
    }

   public function returnProduct(Request $request) {
    $returnedProduct = Product::find($request->editingProductId);
    
    $returnedQty = (int) $request->prodPayload["stocks"];

    if ($returnedQty >= $returnedProduct->stocks) {
        $returnedProduct->delete();
    } else {
        $returnedProduct->stocks = $returnedProduct->stocks - $returnedQty;
        $returnedProduct->save();
    }

    ReturnedProduct::create([
        'productlistId' => $returnedProduct->productlistId,
        'userId' => $returnedProduct->userId,
        'item_code' => $returnedProduct->item_code,
        'qty' => $returnedQty,
        'description' => $request->prodPayload["description"]
    ]);

    return response()->json(['success' => true]);
}

    public function ReturnAll(Request $request){
    $productId = $request->input('id');

    $returnedProduct = Product::find($productId);

    ReturnedProduct::create([
        'productlistId' => $returnedProduct->productlistId,
        'userId' => $request->input('userId', $returnedProduct->userId),
        'item_code' =>$returnedProduct->item_code,
        'qty' => $returnedProduct->stocks,
        'description' => $returnedProduct->description,
    ]);

    
    $returnedProduct->delete();

    return response()->json(['message' => 'Product returned successfully']);
}

    public function deleteProduct(Request $request){

        $deleteProduct = Product::find($request->productId);

        $res = $deleteProduct->delete();
        return $res;
    }
}


