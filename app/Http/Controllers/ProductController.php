<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Categories;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ReturnedProduct;

class ProductController extends Controller{

    public function createProduct(Request $request) {

    $categories = Categories::all();
    $categoryId = $request->input('categoryId');

    $newProduct = new Product();
    $newProduct->categoryId = $categoryId;
    $newProduct->productName = $request->input('productName');
    $newProduct->image = $request->input('image');
    $newProduct->supplierId = $request->input('supplierId');
    $newProduct->item_code = $request->input('item_code');
    $newProduct->price = $request->input('price');
    $newProduct->unit = $request->input('unit');
    $newProduct->qty = $request->input('qty');
    $newProduct->description = $request->input('description');

    $newProduct->status= 0;

    $productSaved = $newProduct->save();
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
        return Product::where('status', 0)->get();
    } elseif ($status === 'approved') {
        return Product::where('status', 1)->get();
    } else {
        return Product::all();
    }
}


    // public function updateProduct(Request $request){
    //     $product = Product :: findOrFail($request->editingProductId);

    //     $product->productName = $request->prodPayload["productName"];
    //     $product->supplierId = $request->prodPayload["supplierId"];
    //     $product->categoryId = $request->prodPayload["categoryId"];
    //     $product->item_code = $request->prodPayload["item_code"];
    //     $product->price = $request->prodPayload["price"];
    //     $product->unit = $request->prodPayload["unit"];
    //     $product->qty = $request->prodPayload["qty"];
    //     $product->description = $request->prodPayload["description"];



    // //    if ($product->status == 1) {

    // //         $transaction = new Transaction();
    // //         $transaction->productId = $product->productId;
    // //         $transaction->supplierId = $product->supplierId;
    // //         $transaction->description = $product->description;
    // //         $transaction->qty = $product->qty;
    // //         $transaction->approved_by = $request->prodPayload["approved_by"];

    // //         $transaction->save();
    // //     }

    //     $product->save();

    //     return $product;

    // }

    public function updateProduct(Request $request){
        $product = Product :: findOrFail($request->editingProductId);

        $product->productName = $request->prodPayload["productName"];
        $product->supplierId = $request->prodPayload["supplierId"];
        $product->categoryId = $request->prodPayload["categoryId"];
        $product->item_code = $request->prodPayload["item_code"];
        $product->price = $request->prodPayload["price"];
        $product->unit = $request->prodPayload["unit"];
        $product->qty = $request->prodPayload["qty"];
        $product->description = $request->prodPayload["description"];
        $product->status = $request->prodPayload["status"];

       if ($product->status == 1) {

            $transaction = new Transaction();
            $transaction->productId = $product->productId;
            $transaction->supplierId = $product->supplierId;
            $transaction->description = $product->description;
            $transaction->qty = $product->qty;
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

    public function getSuppliers()
    {
        return Supplier::all();

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


