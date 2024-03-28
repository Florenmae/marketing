<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductList;
use App\Models\Delivery;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductListController extends Controller
{
    // public function getProductLists()
    // {
    //     $user = Auth::user();
    //     $productLists = $user->productLists;

    //     return $productLists;
    // }


public function createProductList(Request $request){
    $newprod = new ProductList();

    $newprod->id = $request->id;
    $newprod->categoryId = $request->categoryId;
    $newprod->item_code = $request->item_code;
    $newprod->name = $request->name;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public');
        $filename = basename($path);
        $newprod->image = $filename;
    }

    $newprod->price = $request->price;
    $newprod->description = $request->description;

    $res = $newprod->save();

    return $res;
}


    public function getProductLists()
    {   
        return ProductList::all();
        // dd(ProductList::all());
        
    }
}
