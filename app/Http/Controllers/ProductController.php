<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function createProduct(Request $request){
    $newProduct = new Product();

    $newProduct->id = $request->id;
    $newProduct->name = $request->name;
    $newProduct->product_code = $request->product_code;
    $newProduct->item_code = $request->item_code;
    $newProduct->price = $request->price;
    $newProduct->qty = $request-> qty;
    $newProduct->description = $request->description;

    $res = $newProduct->save();

    return $res;
}
    public function getProducts(){
        return Product::all();
        // return  Product::select()->where('id')->get();
    }

    public function updateProduct(Request $request, $id)
{
    $request->validate([
        'product_code' => 'required|string|max:255',
        'item_code' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'price' => 'required|string|max:255',
        'qty' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ]);

    $product = $id ? Product::findOrFail($id) : new Product;

    $product->product_code = $request->input('product_code');
    $product->item_code = $request->input('item_code');
    $product->name = $request->input('name');
    $product->price = $request->input('price');
    $product->qty = $request->input('qty');
    $product->description = $request->input('description');

    $product->save();

    return $product->fresh(); // Optionally return the fresh instance of the updated category
}

    public function deleteProduct(Request $request){
        // dd($request->id);
        $deleteProduct = Product::find($request->id);

        $res = $deleteProduct->delete();
        return $res;
    }
}
