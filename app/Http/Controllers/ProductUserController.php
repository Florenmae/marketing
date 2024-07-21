<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\DeliveryCart;
use App\Models\Transaction;
use App\Models\ProductList;
use App\Models\Inventory;
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

    if ($res) {
            $inventory = new Inventory();
            $inventory->productId = $newProduct->id;
            $inventory->productlistId = $newProduct->productlistId;
            $inventory->categoryId = $newProduct->categoryId;
            $inventory->item_code = $newProduct->item_code;
            $inventory->userId = Auth::id();
            $inventory->image = $newProduct->image;
            $inventory->unit = $newProduct->unit;
            $inventory->description = $newProduct->description;
            $inventory->stocks = $newProduct->stocks;
            $inventory->save();
        }
        
        return $res;
        
}

    public function getProductsUser(Request $request)
{
    $userId = Auth::id();
    $search = $request->input('search');

    $query = Product::join('product_lists', 'products.productlistId', '=', 'product_lists.id')
                    ->where('products.userId', $userId);

    if ($search) {
        $query->where(function ($query) use ($search) {
            $query->Where('product_lists.name', 'like', '%' . $search . '%');
        });
    }

    $products = $query->select('products.*', 'product_lists.name as product_list_name')->get();

    return response()->json($products);
}



public function addToDevCart(Request $request)
{   
    $id = $request->input('id');
    $qty = $request->input('qty', 1);
    $productlistId = $request->input('productlistId');

    $product = Product::find($id);
    //dd($product);
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
                $transaction->productlistId = $product->productlistId;
                $transaction->userId = Auth::id();
                $transaction->roleId = 1;
                $transaction->qty = $subtractedQty;
                $transaction->type = 2;
                $transaction->totalprice = $subtotal; 
                $transaction->save();

                $delivery = new Delivery();
                $delivery->userId = Auth::id();
                $delivery->transactionId = $transaction->id;
                $delivery->productId = $product->id;
                $delivery->productlistId = $product->productlistId;
                $delivery->remarks = $product->remarks;
                $delivery->qty = $subtractedQty; 
                $delivery->status = 3;
                $delivery->save();
            }

            DB::commit();
            DeliveryCart::truncate();
    }

//     public function submitAdmin(Request $request) {
//     DB::beginTransaction();

//     try {
//         $products = $request->input('products');
//         $totalPrice = 0;

//         foreach ($products as $productData) {
//             $productId = $productData['productId'];
//             $subtractedQty = $productData['qty'];

//             // Check if there's an existing transaction for this product
//             $transaction = Transaction::where('productId', $productId)
//                 ->where('userId', Auth::id())
//                 ->where('type', 2) // Assuming type 2 is delivery type
//                 ->first();

//             if ($transaction) {
//                 // Update existing transaction
//                 $transaction->qty += $subtractedQty;
//                 $transaction->totalprice += ($productData['price'] * $subtractedQty);
//                 $transaction->save();

//                 // Update delivery if it exists
//                 $delivery = Delivery::where('transactionId', $transaction->id)->first();
//                 if ($delivery) {
//                     $delivery->qty += $subtractedQty;
//                     $delivery->save();
//                 }
//             } else {
//                 // Create new transaction and delivery
//                 $product = Product::findOrFail($productId);

//                 // Update product stocks
//                 $product->stocks -= $subtractedQty;
//                 if ($product->stocks < 0) {
//                     $product->stocks = 0;
//                 }
//                 $product->status = 2;
//                 $product->save();

//                 // Create new transaction
//                 $transaction = new Transaction();
//                 $transaction->productId = $product->id;
//                 $transaction->productlistId = $product->productlistId;
//                 $transaction->userId = Auth::id();
//                 $transaction->roleId = 1;
//                 $transaction->qty = $subtractedQty;
//                 $transaction->type = 2;
//                 $transaction->totalprice = $product->price * $subtractedQty;
//                 $transaction->save();

//                 // Create new delivery
//                 $delivery = new Delivery();
//                 $delivery->userId = Auth::id();
//                 $delivery->transactionId = $transaction->id;
//                 $delivery->productId = $product->id;
//                 $delivery->productlistId = $product->productlistId;
//                 $delivery->remarks = $product->remarks;
//                 $delivery->qty = $subtractedQty;
//                 $delivery->status = 3; // Adjust status as needed
//                 $delivery->save();
//             }

//             $totalPrice += $transaction->totalprice;
//         }

//         // Commit transaction
//         DB::commit();

//         // Clear delivery cart after successful submission
//         DeliveryCart::truncate();

//         return response()->json([
//             'success' => true,
//             'message' => 'Products delivered successfully',
//             'totalPrice' => $totalPrice,
//         ]);

//     } catch (\Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to submit to admin',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }


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
