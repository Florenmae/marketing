<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ReturnedProduct;

class ProductController extends Controller{

    public function createProduct(Request $request) {

    // // $imagePath = $request->file('image')->store('public/images');
    // $imageName = $request->image->getClientOriginalName();
    // $request->image->move(public_path('images'), $imageName);

    $newProduct = new Product();
    $newProduct->cat_code = $request->input('cat_code');
    $newProduct->image = $request->input('image');
    $newProduct->name = $request->input('name');
    $newProduct->supplier = $request->input('supplier');
    $newProduct->item_code = $request->input('item_code');
    $newProduct->price = $request->input('price');
    $newProduct->qty = $request->input('qty');
    $newProduct->description = $request->input('description');


    $productSaved = $newProduct->save();

    if ($productSaved) {

        $transaction = new Transaction();
        $transaction->name = $newProduct->name;
        $transaction->supplier = $newProduct->supplier;
        $transaction->description = $newProduct->description;
        $transaction->qty = $newProduct->qty;

        $transactionSaved = $transaction->save();

        if ($transactionSaved) {
            return response()->json(['success' => true, 'message' => 'Product and Transaction created successfully']);
        } else {
            $newProduct->delete();
            return response()->json(['success' => false, 'message' => 'Failed to create transaction']);
        }
    } else {
        return response()->json(['success' => false, 'message' => 'Failed to create product']);
    }
}

    public function uploadImage(Request $request) {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = $request->image->getClientOriginalName();
    $request->image->move(public_path('images'), $imageName);

    return response()->json(['imagePath' => $imageName]);
}



    public function getProducts(){
        return Product::all();
    }

    public function updateProduct(Request $request){
        $product = Product :: findOrFail($request->editingProductId);

        $product->name = $request->prodPayload["name"];
        $product->supplier = $request->prodPayload["supplier"];
        $product->cat_code = $request->prodPayload["cat_code"];
        $product->item_code = $request->prodPayload["item_code"];
        $product->price = $request->prodPayload["price"];
        $product->qty = $request->prodPayload["qty"];
        $product->description = $request->prodPayload["description"];
        $product->status = $request->prodPayload["status"];

        $product->save();

        return $product;

    }

    public function deleteProduct(Request $request){
        // dd($request->id);
        $deleteProduct = Product::find($request->id);

        $res = $deleteProduct->delete();
        return $res;
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
        // dd($returnedProduct);
        $returnedProduct->save();
    }

        ReturnedProduct::create([
            'name' => $returnedProduct->name,
            'item_code' => $returnedProduct->item_code,
            'supplier' => $returnedProduct->supplier,
            'qty' => $returnedQty,
            'description' => $returnedProduct->description,

        ]);

        $res = $returnedProduct->save();
    }
}


