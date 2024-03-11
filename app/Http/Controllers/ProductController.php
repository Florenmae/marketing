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

class ProductController extends Controller{

 public function createProduct(Request $request){
        $newproduct = new Product();

        $newproduct->id = $request->id;
        $newproduct->categoryId = $request->categoryId;
        $newproduct->userId = $request->userId;
        $newproduct->item_code = $request->item_code;
        $newproduct->productId = $request->productId;
        $newproduct->image = $request->image;
        $newproduct->price = $request->price;
        $newproduct->unit = $request->unit;
        $newproduct->stocks = $request->stocks;
        $newproduct->description = $request->description;
        $newproduct->status = 1;
        $newproduct->approved_by = $request->approved_by;

        $res = $newproduct->save();

        return $res;
    }

    public function uploadImage(Request $request) {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = $request->image->getClientOriginalName();
    $request->image->move(public_path('images'), $imageName);

    return response()->json(['imagePath' => $imageName]);
}

    public function getProducts($status = null) {
        if ($status === 'pending') {
            return Product::where('status', 2)->get();
        } elseif ($status === 'approved') {
            return Product::where('status', 3)->get();
        } elseif ($status === 'returned') {
            return Product::where('status', 4)->get();
        } 
    }

    // public function updateProduct(Request $request){
    //     $product = Product :: findOrFail($request->editingProductId);

    //     // $product->name = $request->prodPayload["name"];
    //     $product->userId = $request->prodPayload["userId"];
    //     $product->categoryId = $request->prodPayload["categoryId"];
    //     $product->item_code = $request->prodPayload["item_code"];
    //     $product->price = $request->prodPayload["price"];
    //     $product->unit = $request->prodPayload["unit"];
    //     $product->stocks = $request->prodPayload["stocks"];
    //     $product->description = $request->prodPayload["description"];
    //     $product->status = $request->prodPayload["status"];
    //     $product->approved_by = $request->prodPayload["approved_by"];

    //    if ($product->status == 3) {

    //         $transaction = new Transaction();
    //         $transaction->productId = $product->id;
    //         $transaction->userId = $product->userId;
    //         $transaction->type= $request->prodPayload["type"];
    //         $transaction->qty = $product->stocks;
    //         //$transaction->stocks = $product->stocks;
    //         $transaction->actualQty = $request->prodPayload["actualQty"];

    //         $transaction->save();

    //         $product->qty += $product->actualQty;
    //     }

    //     $product->save();

    //     return $product;

    // }

    public function updateProduct(Request $request){
    $product = Product::findOrFail($request->editingProductId);

    $product->userId = $request->prodPayload["userId"];
    $product->categoryId = $request->prodPayload["categoryId"];
    $product->item_code = $request->prodPayload["item_code"];
    $product->price = $request->prodPayload["price"];
    $product->unit = $request->prodPayload["unit"];

    $delivery = Delivery::where('productId', $product->id)->pluck('qty')->first();
    
    $product->description = $request->prodPayload["description"];
    $product->status = $request->prodPayload["status"];
    $product->approved_by = $request->prodPayload["approved_by"];

    if ($product->status == 3) {
        $transaction = new Transaction();
        $transaction->productId = $product->id;
        $transaction->userId = Auth::id();
        $transaction->type = $request->prodPayload["type"];
        $transaction->qty = $request->prodPayload["actualQty"]; 
        $transaction->actualQty = $request->prodPayload["actualQty"];

        $product->stocks += $request->prodPayload["actualQty"];

        $transaction->stocks = $product->stocks;

        $transaction->save();
    }

    $product->save();

    return $product;
}

    public function getCategories()
    {
        return Categories::all();

    }

    public function fetchDeliveries()
    {
        return Delivery::all();
        // dd(Delivery::all());
        // $deliveries = Delivery::select('qty')->get();
        
        // return $deliveries;

    }

    public function getUsers()
    {
         return User::where('id', '!=', '1')->get();

    }

    public function returnProduct(Request $request){
        $returnedProduct = Product::find($request->editingProductId);

        if (!$returnedProduct) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $returnedQty = (int)$request->prodPayload["qty"];

    if ($returnedQty >= $returnedProduct->qty) {
        $returnedProduct->delete();
    } else {
        $returnedProduct->qty = $returnedProduct->qty - $returnedQty;
        $returnedProduct->save();
    }

        ReturnedProduct::create([
            'productId' => $returnedProduct->productId,
            'supplierId' => $returnedProduct->supplierId,
            'qty' => $returnedQty,
            'description' => $request->prodPayload["description"]

        ]);

        $res = $returnedProduct->save();
    }

    public function ReturnAll(Request $request){
        $returnedProduct = Product::find($request->product['productId']);

        ReturnedProduct::create([
            'name' => $returnedProduct->productId,
            'supplier' => $returnedProduct->supplierId,
            'qty' => $returnedProduct->qty,
            'description' => $returnedProduct->description,

        ]);

        $res = $returnedProduct->save();
        $returnedProduct->delete();
    }
}


