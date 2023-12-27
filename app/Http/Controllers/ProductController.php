<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
//     public function product(){
//     return response()->json(Product::all(), 200);
// }

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
    public function getProducts(){
    return products::select()->where('id')->get();
    }

    public function  getProduct(Request $request){

        if(product::where('id', $request->edit_id)->exists()){
            return product::find($request->edit_id);
        }
        else{
            return $data = (object)[ 
                "id"=>0,
                "item_code"=> "",
                "product_code"=> "",
                "name"=> "",
                "price"=> "",
                "qty"=> "",
                "description"=>""

            ];
        }
    }
}
