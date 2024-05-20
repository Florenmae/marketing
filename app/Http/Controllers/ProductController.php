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

    public function approveProduct(Request $request){

    DB::beginTransaction();

    try {
        $productId = $request->editingProductId;
        $product = Product::findOrFail($productId);

        // Approve and update the existing product
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


    // public function ReturnAll(Request $request){
    //     $returnedProduct = Product::find($request->product['productId']);
    //     dd($returnedProduct);
    //     ReturnedProduct::create([
    //         'productlistId' => $returnedProduct->productlistId,
    //         'userId' => $returnedProduct->userId,
    //         'qty' => $returnedProduct->qty,
    //         'description' => $returnedProduct->description,

    //     ]);

    //     $res = $returnedProduct->save();
    //     $returnedProduct->delete();
    // }

    public function ReturnAll(Request $request){
    try {
        // Find the product by ID
        $returnedProduct = Product::findOrFail($request->product['productlistId']);
        dd($returnedProduct);
        // Create a new ReturnedProduct instance
        ReturnedProduct::create([
            'productlistId' => $returnedProduct->productlistId,
            'supplier' => $returnedProduct->userId,
            'qty' => $returnedProduct->qty,
            'description' => $returnedProduct->description,
        ]);

        $returnedProduct->delete();

        return response()->json(['success' => 'Product returned successfully'], 200);
    } catch (ModelNotFoundException $exception) {
        return response()->json(['error' => 'Product not found'], 404);
    } catch (Exception $exception) {
        // Handle any other exceptions
        return response()->json(['error' => $exception->getMessage()], 500);
    }
}

    public function deleteProduct(Request $request){

        $deleteProduct = Product::find($request->productId);

        $res = $deleteProduct->delete();
        return $res;
    }
}


