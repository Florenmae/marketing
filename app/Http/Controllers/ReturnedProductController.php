<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnedProduct;
use App\Models\Product;

class ReturnedProductController extends Controller
{
    public function getReturnedProducts(){
        $returnedProducts = Product::where('status', 'returned')->get();
        return $returnedProducts;

    }

    public function updateReturnedProduct(Request $request){
        $retproduct = ReturnedProduct :: findOrFail($request->editingReturnedProductId);

        $retproduct->ret_name = $request->retPayload["ret_name"];
        $retproduct->supplier = $request->retPayload["supplier"];
        $retproduct->item_code = $request->retPayload["item_code"];
        $retproduct->qty = $request->retPayload["qty"];
        $retproduct->description = $request->retPayload["description"];
        $retproduct->status = $request->retPayload["status"];

        $retproduct->save();

        return $retproduct;

    }

    public function processReturn($productId)
{
    $product = Product::find($productId);
    if ($product->status === 'returned') {
        ReturnedProduct::create(['product_id' => $product->id]);

        $product->delete();

        return redirect()->route('your.route');
    } else {

        return redirect()->back()->with('error', 'Product cannot be returned.');
    }
}
}

