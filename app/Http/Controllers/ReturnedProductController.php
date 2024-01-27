<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnedProduct;
use App\Models\Product;

class ReturnedProductController extends Controller
{
     public function createReturns(Request $request){
        $newReturns =  new ReturnedProduct();
<<<<<<< HEAD
        // $currentProduct = Product::find($request->id);
=======
        $currentProduct = Product::find($request->editingProductId);

>>>>>>> 56326e53543457e0ddd35690d4b2a3ea39d8ac5b
        $newReturns->id = $request->id;
        $newReturns->name = $request->name;
        $newReturns->supplier = $request->supplier;
        $newReturns->item_code = $request->item_code;
        $newReturns->qty = $request-> qty;
        $newReturns->description = $request->description;
        // $newReturns->status = $request->status;
<<<<<<< HEAD
=======
        $currentProduct->qty = $currentProduct->qty-$request->qty;
>>>>>>> 56326e53543457e0ddd35690d4b2a3ea39d8ac5b

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
}

