<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnedProduct;
use App\Models\Product;

class ReturnedProductController extends Controller
{
     public function createReturns(Request $request)
{
    $newReturns = new ReturnedProduct();
    $currentProduct = Product::find($request->editingProductId);

    $newReturns->id = $request->id;
    $newReturns->name = $request->name;
    $newReturns->supplier = $request->supplier;
    $newReturns->item_code = $request->item_code;
    $newReturns->qty = $request->qty;
    $newReturns->description = $request->description;

    // Update the current product's quantity
    $currentProduct->qty -= $request->qty;

    // Save the changes to the current product
    $currentProduct->save();

    // Save the new returns record
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

    public function updateReturnedProduct(Request $request){
        $retproduct = ReturnedProduct :: findOrFail($request->editingReturnedProductId);

        $retproduct->name = $request->retPayload["name"];
        $retproduct->supplier = $request->retPayload["supplier"];
        $retproduct->item_code = $request->retPayload["item_code"];
        $retproduct->qty = $request->retPayload["qty"];
        $retproduct->description = $request->retPayload["description"];

        $retproduct->save();

        return $retproduct;

    }
    public function deleteReturn(Request $request){
        // dd($request->id);
        $deleteReturn = ReturnedProduct::find($request->id);

        $res = $deleteReturn->delete();
        return $res;
    }
}

