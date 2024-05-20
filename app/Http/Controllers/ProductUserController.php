<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\DeliveryCart;
use App\Models\Transaction;
use App\Models\ProductList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProductUserController extends Controller
{


    public function createProduct(Request $request)
    {
   
    $request->validate([
        'categoryId' => 'required|exists:categories,id',
        'productlistId' => 'required|exists:product_lists,id',
        'unit' => 'required|string',
        'stocks' => 'required|integer',
        'description' => 'required|string',
        
    ]);

    $productList = ProductList::findOrFail($request->productlistId);

    $newProduct = new Product();

    $newProduct->categoryId = $request->categoryId;
    $newProduct->userId = Auth::id();
    $newProduct->productlistId = $request->productlistId;
    $newProduct->item_code = $productList->item_code; 
    $newProduct->image = $productList->image;
    $newProduct->price = $productList->price; 
    $newProduct->unit = $request->unit;
    $newProduct->stocks = $request->stocks;
    $newProduct->description = $request->description;
    $newProduct->status = 1; 
    $newProduct->approved_by = $request->approved_by;
    
    $res = $newProduct->save();

    return $res;
}


//     public function uploadImage(Request $request) {
//     $request->validate([
//         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     $imageName = $request->image->getClientOriginalName();
//     $request->image->move(public_path('images'), $imageName);

//     return response()->json(['imagePath' => $imageName]);
// }



    public function getProductsUser()
    {
        $user = Auth::user();
        $products = $user->products;

        return $products;
    }

// public function submitAdmin(Request $request)
// {
//         DB::beginTransaction();

//         $products = $request->input('products');

//         foreach ($products as $productData) {
//             $id = $productData['id'];

//             $product = Product::findOrFail($id);

//             $originalStock = $product->stocks;

//             $subtractedQty = $productData['qty'];
//             $product->stocks -= $subtractedQty;

//             if ($product->stocks < 0) {
//                 $product->stocks = 0;
//             }

//             $product->price;
//             $product->status = 2;

//             $product->save();
            

//             $transaction = new Transaction();
//             $transaction->productId = $product->id;
//             $transaction->userId = Auth::id();
//             $transaction->qty = $subtractedQty; 
//             $transaction->save();

           
//             $delivery = new Delivery();
//             $delivery->userId = Auth::id();
//             $delivery->transactionId = $transaction->id;
//             $delivery->productId = $product->id;
//             $delivery->qty = $subtractedQty; 
//             $delivery->status = 3;
//             $delivery->save();
//         }

//         DB::commit();
//         DeliveryCart::truncate();

// }

public function addToDevCart(Request $request)
{   
    $id = $request->input('id');
    $qty = $request->input('qty', 1);
    $productlistId = $request->input('productlistId');

    $product = Product::find($id);
    
    $cartItem = DeliveryCart::where('productId', $id)
                            ->where('productlistId', $productlistId)
                            ->first();

    if ($cartItem) {
        $cartItem->qty += $qty;
        $cartItem->price = $product->price * $cartItem->qty;
        $cartItem->save();
    } else {
        DeliveryCart::create([
            'productId' => $id,
            'productlistId' => $productlistId,
            'price' => $product->price * $qty,
            'qty' => $qty,
        ]);
    }

    return response()->json(['message' => 'Cart updated successfully'], 200);
}



    public function submitAdmin(Request $request){
        DB::beginTransaction();

            $products = $request->input('products');
            $totalPrice = 0;

            foreach ($products as $productData) {
                $productId = $productData['productId'];

                $product = Product::findOrFail($productId);
            
                $originalStock = $product->stocks;

                $subtractedQty = $productData['qty'];
                $product->stocks -= $subtractedQty;

                if ($product->stocks < 0) {
                    $product->stocks = 0;
                }

                $product->price;
                $product->status = 2;

                $subtotal = $product->price * $subtractedQty;
                $totalPrice += $subtotal;
                
                $product->save();

                $transaction = new Transaction();
                $transaction->productId = $product->id;
                $transaction->userId = Auth::id();
                $transaction->qty = $subtractedQty;
                $transaction->type = 2;
                $transaction->totalprice = $subtotal; 
                $transaction->save();

                $delivery = new Delivery();
                $delivery->userId = Auth::id();
                $delivery->transactionId = $transaction->id;
                $delivery->productId = $product->id;
                $delivery->qty = $subtractedQty; 
                $delivery->status = 3;
                $delivery->save();
            }

            DB::commit();
            DeliveryCart::truncate();
    }

    public function getCategories()
        {
            return Categories::all();

        }

    public function getProductLists()
    {   
        return ProductList::all();

    }

    public function deleteProduct(Request $request){
        $deleteProduct = Product::find($request->id);
        //dd($deleteProduct);
        $res = $deleteProduct->delete();
        return $res;
    }


    public function showCartItems(Request $request){
        return DeliveryCart::all();
       
    }

    public function deleteItem(Request $request){
        $deleteItem = DeliveryCart::find($request->id);
       
        $res = $deleteItem->delete();
        return $res;
    }

}
