<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ReturnedProduct;

class ProductController extends Controller
{
    public function createProduct(Request $request){
        $newProduct =  new Product();

        $newProduct->id = $request->id;
        $newProduct->cat_code= $request->input('cat_code');
        $newProduct->name = $request->name;
        $newProduct->supplier = $request->supplier;
        $newProduct->item_code = $request->item_code;
        $newProduct->price = $request->price;
        $newProduct->qty = $request-> qty;
        $newProduct->description = $request->description;

        $res = $newProduct->save();

        return $res;
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

    // public function approveStatus($productId) {
    //     $product = Product::find($productId);
    //     $product->status = 'approved';
    //     $product->save();

    //     return response()->json(['message' => 'Product status approved']);
    // }

    // public function rejectStatus($productId) {
    //     $product = Product::find($productId);
    //     $product->status = 'rejected';
    //     $product->save();

    //     return response()->json(['message' => 'Product status rejected']);
    // }


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
        $returnedProduct->qty = $returnedProduct->qty-$returnedQty;
        // dd($returnedProduct);
        $returnedProduct->save();
    }

        ReturnedProduct::create([
            'name' => $returnedProduct->name,
            'item_code' => $returnedProduct->item_code,
            'supplier' => $returnedProduct->supplier,
            'qty' => $returnedProduct->qty,
            'description' => $returnedProduct->description,

        ]);

        $res = $returnedProduct->save();
    }

    // ReturnedProduct::create([
    //     $returnedProduct->name = $request->retPayload["name"],
    //     $returnedProduct->item_code  = $request->retPayload["item_code"],
    //     $returnedProduct->supplier  = $request->retPayload["supplier"],
    //     $returnedProduct->qty = $request->retPayload["qty"],
    //     $returnedProduct->description = $request->retPayload["description"],
    // ]);

    // $res = $returnedProduct->save();
}


