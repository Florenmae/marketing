<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Categories;
use App\Models\Product;
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
    public function recentProducts()
    {
        $recentProducts = Product::latest()->take(5)->get();

        return $recentProducts;
    }
}
