<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function product(){
    return response()->json(Product::all(), 200);
}

    public function createProduct(Request $request){
    $newProduct = new product();

    $newProduct->id = $request->id;
    $newProduct->item_code = $request->item_code;
    $newProduct->product_code = $request->product_code;
    $newProduct->name = $request->name;
    $newProduct->price = $request->price;
    $newProduct->qty = $request-> qty;
    $newProduct->description = $request->description;

    $res = $newProduct->save();

    return $res;
}
}
