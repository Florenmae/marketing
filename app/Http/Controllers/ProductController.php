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

 public function createProduct(Request $request){
        $newproduct = new Product();

        $newproduct->categoryId = $request->categoryId;
        $newproduct->userId = $request->userId;
        $newproduct->productId = $request->productId;
        $newproduct->item_code = $request->item_code;
        $newproduct->image = $request->image;
        $newproduct->price = $request->price;
        $newproduct->unit = $request->unit;
        $newproduct->stocks = $request->stocks;
        $newproduct->description = $request->description;
        $newproduct->status = 1; 
        $newproduct->approved_by = $request->approved_by;

        $res = $newproduct->save();
    }

    public function uploadImage(Request $request) {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = $request->image->getClientOriginalName();
    $request->image->move(public_path('images'), $imageName);

    return response()->json(['imagePath' => $imageName]);
}


    public function updateProduct(Request $request){
        DB::beginTransaction();

        $productId = $request->editingProductId;
        $product = Product::findOrFail($productId);

        $product->userId = $request->prodPayload["userId"];
        $product->categoryId = $request->prodPayload["categoryId"];
        $product->item_code = $request->prodPayload["item_code"];
        $product->price = $request->prodPayload["price"];
        $product->unit = $request->prodPayload["unit"];
        $product->description = $request->prodPayload["description"];
        $product->status = $request->prodPayload["status"];
        $product->approved_by = $request->prodPayload["approved_by"];

        if ($product->status == 3) {
            $actualQty = $request->prodPayload["actualQty"];

            $transaction = new Transaction();
            $transaction->productId = $product->id;
            $transaction->userId = Auth::id();
            $transaction->type = $request->prodPayload["type"];
            // $transaction->qty = $qty; 
            $transaction->actualQty = $actualQty;

            $product->stocks -= $actualQty;
            $transaction->stocks = $product->stocks;

            $transaction->save();
        }

        $adminProduct = Product::where('userId', 1)
                                ->where('productId', $productId)
                                ->first();

        if ($adminProduct) {
            $adminProduct->stocks += $request->prodPayload["actualQty"];
            $adminProduct->save();
        } else {
            $adminProduct = $product->replicate();
            $adminProduct->userId = 1; 
            $adminProduct->stocks = $request->prodPayload["actualQty"];
            $adminProduct->save();
        }


        $product->save();

        DB::commit();

        return $product;
}

// public function updateProduct(Request $request){
//     DB::beginTransaction();

//     try {
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

//             // Find the existing transaction for the product
//             $transaction = Transaction::where('productId', $product->id)->first();
//             if ($transaction) {
//                 // Update the existing transaction
//                 $transaction->qty = -$actualQty;
//                 $transaction->actualQty = $actualQty;
//                 $transaction->stocks = $product->stocks - $actualQty; // Update stocks
//                 $transaction->save();
//             } else {
//                 // No existing transaction found, create a new one
//                 $transaction = new Transaction();
//                 $transaction->productId = $product->id;
//                 $transaction->userId = Auth::id();
//                 $transaction->type = $request->prodPayload["type"];
//                 $transaction->qty = -$actualQty; 
//                 $transaction->actualQty = $actualQty;
//                 $transaction->stocks = $product->stocks - $actualQty; // Update stocks
//                 $transaction->save();
//             }

//             // Subtract from product stocks
//             $product->stocks -= $actualQty;
//         }

//         // Update admin product
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
//     } catch (\Exception $e) {
//         DB::rollback();
//         // Log or handle the exception as needed
//         return response()->json(['error' => 'An error occurred while updating the product.'], 500);
//     }
// }

    public function getCategories()
    {
        return Categories::all();

    }

//     public function getProducts($status = null) {
//     if ($status === 'pending') {
//         return Product::where('status', 2)->get();
//     } elseif ($status === 'approved') {
//         return Product::where('status', 3)->get();
//     } elseif ($status === 'returned') {
//         return Product::where('status', 4)->get();
//     } else {
//         return Product::all();
//     }
// }



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
         return User::where('id', '!=', '1')->get();

    }

    public function returnProduct(Request $request){
        $returnedProduct = Product::find($request->editingProductId);

        $returnedQty = (int)$request->prodPayload["stocks"];

    if ($returnedQty >= $returnedProduct->stocks) {
        $returnedProduct->delete();
    } else {
        $returnedProduct->stocks = $returnedProduct->stocks - $returnedQty;
        $returnedProduct->save();
    }

        ReturnedProduct::create([
            'productId' => $returnedProduct->productId,
            'userId' => $returnedProduct->userId,
            'stocks' => $returnedQty,
            'description' => $request->prodPayload["description"]

        ]);

        $res = $returnedProduct->save();
    }

    public function ReturnAll(Request $request){
        $returnedProduct = Product::find($request->product['productId']);

        ReturnedProduct::create([
            'name' => $returnedProduct->productId,
            'supplier' => $returnedProduct->userId,
            'qty' => $returnedProduct->qty,
            'description' => $returnedProduct->description,

        ]);

        $res = $returnedProduct->save();
        $returnedProduct->delete();
    }
}


