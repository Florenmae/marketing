<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductList;
use App\Models\User;
use App\Models\Role;
use App\Models\Categories;
use App\Models\Delivery;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ReturnedProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller{

//     public function approveProduct(Request $request){

//     DB::beginTransaction();

//     try {
//         $productId = $request->editingProductId;
//         $product = Product::findOrFail($productId);

//         $product->userId = $request->prodPayload["userId"];
//         $product->categoryId = $request->prodPayload["categoryId"];
//         $product->item_code = $request->prodPayload["item_code"];
//         $product->price = $request->prodPayload["price"];
//         $product->unit = $request->prodPayload["unit"];
//         $product->description = $request->prodPayload["description"];
//         $product->status = 3; 
//         $product->approved_by = $request->prodPayload["approved_by"];
//         $product->save();

//         if ($product->status == 3) {
//             $actualQty = $request->prodPayload["actualQty"];

//             $transaction = Transaction::where('productId', $product->id)->first();
//             if ($transaction) {
//                 $transaction->qty = -$actualQty;
//                 $transaction->actualQty = $actualQty;
//                 $transaction->stocks = $product->stocks - $actualQty; 
//                 $transaction->save();
//             } else {
                
//                 $transaction = new Transaction();
//                 $transaction->productId = $product->id;
//                 $transaction->userId = Auth::id();
//                 $transaction->type = $request->prodPayload["type"];
//                 $transaction->qty = -$actualQty;
//                 $transaction->actualQty = $actualQty;
//                 $transaction->stocks = $product->stocks - $actualQty;
//                 $transaction->save();
//             }

//             $product->stocks -= $actualQty;
//         }

//         $adminProduct = new Product();
//         $adminProduct->userId = 1;
//         $adminProduct->categoryId = $product->categoryId;
//         $adminProduct->productlistId = $product->productlistId;
//         $adminProduct->item_code = $product->item_code;
//         $adminProduct->price = $product->price;
//         $adminProduct->image = $product->image;
//         $adminProduct->unit = $product->unit;
//         $adminProduct->stocks = $actualQty;
//         $adminProduct->description = $product->description;
//         $adminProduct->status = 3; 
//         $adminProduct->approved_by = $product->approved_by;
//         $adminProduct->save();

//         DB::commit();

//         return response()->json(['success' => true]);
//     } catch (\Exception $e) {
//         DB::rollback();
//         return response()->json(['success' => false, 'message' => $e->getMessage()]);
//     }
// }

    public function approveProduct(Request $request) {
    DB::beginTransaction();

    try {
        $productId = $request->editingProductId;
        $product = Product::findOrFail($productId);

        // Update the product with approval details
        $product->userId = $request->prodPayload["userId"];
        $product->categoryId = $request->prodPayload["categoryId"];
        $product->item_code = $request->prodPayload["item_code"];
        $product->price = $request->prodPayload["price"];
        $product->unit = $request->prodPayload["unit"];
        $product->description = $request->prodPayload["description"];
        $product->status = 3; // Assuming status 3 is approved
        $product->approved_by = $request->prodPayload["approved_by"];
        $product->save();

        // If the product is approved, proceed with quantity adjustment
        if ($product->status == 3) {
            $actualQty = $request->prodPayload["actualQty"];
            $productlistId = $product->productlistId;
            $approvedBy = $product->approved_by;

            // Check if there's an existing approved product with the same productlistId and approved_by
            $existingProduct = Product::where('productlistId', $productlistId)
                ->where('approved_by', $approvedBy)
                ->where('status', 3) // Assuming status 3 is approved
                ->first();

            if ($existingProduct) {
                // Update existing product and create/update transaction
                $existingProduct->stocks += $actualQty;
                $existingProduct->save();

                $transaction = Transaction::where('productId', $existingProduct->id)->first();
                if ($transaction) {
                    // Update existing transaction
                    $transaction->qty += $actualQty;
                    $transaction->actualQty += $actualQty;
                    $transaction->stocks = $existingProduct->stocks - $actualQty; // Assuming stocks should be deducted
                    $transaction->save();
                } else {
                    // Create new transaction if not found (should not normally happen)
                    $transaction = new Transaction();
                    $transaction->productId = $existingProduct->id;
                    $transaction->userId = Auth::id();
                    $transaction->type = $request->prodPayload["type"];
                    $transaction->qty = $actualQty;
                    $transaction->actualQty = $actualQty;
                    $transaction->stocks = $existingProduct->stocks - $actualQty; // Assuming stocks should be deducted
                    $transaction->save();
                }
            } else {
                // Create new product entry if no existing approved product found
                $newAdminProduct = new Product();
                $newAdminProduct->userId = 1; // Admin user ID
                $newAdminProduct->categoryId = $product->categoryId;
                $newAdminProduct->productlistId = $product->productlistId;
                $newAdminProduct->item_code = $product->item_code;
                $newAdminProduct->price = $product->price;
                $newAdminProduct->image = $product->image; // Adjust as per your needs
                $newAdminProduct->unit = $product->unit;
                $newAdminProduct->stocks = $actualQty; // Stocks added to admin product
                $newAdminProduct->description = $product->description;
                $newAdminProduct->status = 3; // Assuming status 3 is approved
                $newAdminProduct->approved_by = $product->approved_by;
                $newAdminProduct->save();

                // Create new transaction for the new admin product
                $transaction = new Transaction();
                $transaction->productId = $newAdminProduct->id;
                $transaction->userId = Auth::id();
                $transaction->type = $request->prodPayload["type"];
                $transaction->qty = $actualQty;
                $transaction->actualQty = $actualQty;
                $transaction->stocks = $newAdminProduct->stocks - $actualQty; // Assuming stocks should be deducted
                $transaction->save();
            }

            // Deduct the actual quantity from the original product stocks
            $product->stocks -= $actualQty;
            $product->save();
        }

        DB::commit();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}



    public function getCategories()
    {
        return Categories::all();

    }

    public function getProducts()
    {
        return Product::all();
    }

    public function fetchDeliveries()
    {
        return Delivery::all();
    }

    public function getProductLists()
    {
        return ProductList::all();
    }

    public function getUsers()
    {
         return User::all();

    }

    public function getOrders()
    {
        return Order::whereIn('status', [2, 3])->get();
    }

   public function returnProduct(Request $request) {
    $returnedProduct = Product::find($request->editingProductId);
    
    $returnedQty = (int) $request->prodPayload["stocks"];

    if ($returnedQty >= $returnedProduct->stocks) {
        $returnedProduct->delete();
    } else {
        $returnedProduct->stocks = $returnedProduct->stocks - $returnedQty;
        $returnedProduct->save();
    }

    ReturnedProduct::create([
        'productlistId' => $returnedProduct->productlistId,
        'userId' => $returnedProduct->userId,
        'item_code' => $returnedProduct->item_code,
        'qty' => $returnedQty,
        'description' => $request->prodPayload["description"]
    ]);

    return response()->json(['success' => true]);
}

    public function ReturnAll(Request $request){
    $productId = $request->input('id');

    $returnedProduct = Product::find($productId);

    ReturnedProduct::create([
        'productlistId' => $returnedProduct->productlistId,
        'userId' => $request->input('userId', $returnedProduct->userId),
        'item_code' =>$returnedProduct->item_code,
        'qty' => $returnedProduct->stocks,
        'description' => $returnedProduct->description,
    ]);

    
    $returnedProduct->delete();

    return response()->json(['message' => 'Product returned successfully']);
}

    public function deleteProduct(Request $request){

        $deleteProduct = Product::find($request->productId);

        $res = $deleteProduct->delete();
        return $res;
    }
}


