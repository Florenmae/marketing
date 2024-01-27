<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnedProduct;
use App\Models\Product;

class ReturnedProductController extends Controller
{
     public function createReturns(Request $request){
        $newReturns =  new ReturnedProduct();
        // $currentProduct = Product::find($request->id);
        $newReturns->id = $request->id;
        $newReturns->name = $request->name;
        $newReturns->supplier = $request->supplier;
        $newReturns->item_code = $request->item_code;
        $newReturns->qty = $request-> qty;
        $newReturns->description = $request->description;
        // $newReturns->status = $request->status;

        $res = $newReturns->save();

        return $res;
    }

    public function getReturnedProducts(){
        return ReturnedProduct::all();

    }

    public function fetchReturnedProducts(){
        $returnedProducts = Product::where('status', 'returned')->get();
        return $returnedProducts;

    }
//     public function getReturnedProducts(){
//     $returnedProducts = ReturnedProduct::all();
//     $productsWithReturnedStatus = Product::where('status', 'returned')->get();

//     $combinedResults = $returnedProducts->union($productsWithReturnedStatus);

//     return $combinedResults;
// }

    public function updateReturnedProduct(Request $request){
        $retproduct = ReturnedProduct :: findOrFail($request->editingReturnedProductId);

        $retproduct->name = $request->retPayload["name"];
        $retproduct->supplier = $request->retPayload["supplier"];
        $retproduct->item_code = $request->retPayload["item_code"];
        $retproduct->qty = $request->retPayload["qty"];
        $retproduct->description = $request->retPayload["description"];
        $retproduct->status = $request->retPayload["status"];

        $retproduct->save();

        return $retproduct;

    }
}

