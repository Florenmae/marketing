<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $productCount = Product::where('status', 3)->count();

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
