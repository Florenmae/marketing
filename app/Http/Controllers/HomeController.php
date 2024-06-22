<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\ReturnedProduct;



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

    public function getSalesCount()
    {
        $salesCount = Transaction::count();

        return response()->json(['count' => $salesCount]);
    }

    public function recentProducts()
    {
        $recentProducts = Product::latest()->take(5)->get();

        return $recentProducts;
    }

    public function getSoldItems()
{
    $userId = Auth::id();

    $transactions = Transaction::where('userId', $userId)->get();


    $totalSoldAmount = 0; 
    $soldItems = [];
    
    foreach ($transactions as $transaction) {
        $totalSoldAmount += $transaction->totalprice;

        $soldItem = [
            'productlistId' => $transaction->productlistId,
            'qty' => $transaction->qty,
            'totalPrice' => $transaction->totalprice,
        ];

        $soldItems[] = $soldItem;
    }

    $response = [
        'soldItems' => $soldItems,
        'totalSoldAmount' => $totalSoldAmount,
    ];

    return response()->json($response);
}


   public function getReturnedItems(Request $request)
{
    $userId = Auth::id();
    $returnedProducts = ReturnedProduct::where('userId', $userId)->get();

    $return = $returnedProducts->map(function ($returns) {
        return [
            'productlistId' => $returns->productlistId,
            'qty' => $returns->qty,
            'created_at' => Carbon::parse($returns->created_at)->format('F d, Y'),
            'updated_at' => Carbon::parse($returns->updated_at)->format('F d, Y'),
        ];
    });

    return response()->json($return);
}




}
