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
use Illuminate\Support\Facades\DB;

class ProductListController extends Controller
{
    
public function createProductList(Request $request){
        $newproduct = new ProductList();

        $newproduct->categoryId = $request->categoryId;
        $newproduct->item_code = $request->item_code;
        $newproduct->image = $request->image;
        $newproduct->name = $request->name;
        $newproduct->description = $request->description;
        $newproduct->price = $request->price;

        $res = $newproduct->save();
    }

public function uploadImages(Request $request) {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = $request->image->getClientOriginalName();
    $request->image->move(public_path('images'), $imageName);

    return response()->json(['imagePath' => $imageName]);
}


    // public function getProductLists(Request $request)
    // {   
    //     $query = ProductList::query();

    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $query->where('name', 'like', '%' . $search . '%');
    //     }

    //     $productlist = ProductList::paginate(4);

    //     return [ 
    //         'data' => $productlist->items(),
    //         'pagination' => [
    //         'currentPage' => $productlist->currentPage(),
    //         'totalItems' => $productlist->total(),
    //         'itemsPerPage' => $productlist->perPage(),
    //         'lastPage' => $productlist->lastPage(),
    //     ],
    // ];

    // }

    public function getProductLists(Request $request)
    {
        $query = ProductList::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $productlists = $query->paginate(5);

        return [
            'data' => $productlists->items(),
            'pagination' => [
                'currentPage' => $productlists->currentPage(),
                'totalItems' => $productlists->total(),
                'itemsPerPage' => $productlists->perPage(),
                'lastPage' => $productlists->lastPage(),
            ],
        ];
    }




    public function updateProductList(Request $request){
        DB::beginTransaction();

        $productId = $request->editingProductId;
        $product = ProductList::findOrFail($productId);

        $product->categoryId = $request->prodPayload["categoryId"];
        $product->name = $request->prodPayload["name"];
        $product->item_code = $request->prodPayload["item_code"];
        $product->price = $request->prodPayload["price"];
        $product->description = $request->prodPayload["description"];


        $product->save();

        DB::commit();

        return $product;
    }

    public function getItemCode(Request $request){
        
        $itemCode = mt_rand(1000, 9999);

        return response()->json(['item_code' => $itemCode], 200);
    }
}
