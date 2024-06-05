<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\ReturnedProduct;
use Carbon\Carbon;


class HomeController extends Controller
{

    public function getUserCount()
    {
        $userCounts = User::count();

        return response()->json(['count' => $userCounts]);
    }
    public function getProductCount()
    {
        $userId = Auth::id();
        $productCount = Product::where('status', 3)
            ->where('userId', $userId)
            ->count();

        return response()->json(['count' => $productCount]);
    }
    
    public function getCategoryCount()
    {
        $categoryCount = Categories::count();
        // dd($categoryCount);
        return response()->json(['count' => $categoryCount]);
    }

    public function getReturnCount()
    {
        $returnCount = ReturnedProduct::count();

        return response()->json(['count' => $returnCount]);
    }

    public function recentProducts()
    {
        $recentProducts = Product::latest()->take(5)->get();

        return $recentProducts;
    }

    public function getSoldItems()
{
    $userId = 1; 
    $transactions = Transaction::where('userId', $userId)->paginate(5);

    $soldItems = [];
    $totalSoldAmount = 0; 

    foreach (Transaction::where('userId', $userId)->get() as $transaction) {
        $totalSoldAmount += $transaction->totalprice; 
    }

    foreach ($transactions as $transaction) {
        $soldItem = [
            'productId' => $transaction->productId,
            'qty' => $transaction->actualQty,
            'totalPrice' => $transaction->totalprice,
        ];

        $soldItems[] = $soldItem;
    }

    return [
        'soldItems' => $soldItems,
        'totalSoldAmount' => $totalSoldAmount,
        'pagination' => [
            'currentPage' => $transactions->currentPage(),
            'totalItems' => $transactions->total(),
            'itemsPerPage' => $transactions->perPage(),
            'lastPage' => $transactions->lastPage(),
        ],
    ];
}


    public function getReturnedItems (Request $request){
        $returnedProducts = ReturnedProduct::all();

        $return = $returnedProducts->map(function ($returns) {
            return [
                'productlistId' => $returns->productlistId,
                'quantity' => $returns->qty,
                'created_at' => Carbon::parse($returns->created_at)->format('F d, Y'),
            ];
        });
        return response()->json($return);
    }



}
