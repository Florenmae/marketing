<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categories;
use App\Models\Product;

class HomeController extends Controller
{

    public function getUserCount()
    {
        $userCounts = User::count();

        return response()->json(['count' => $userCounts]);
    }
    public function getProductCount()
    {
        $productCount = Product::count();

        return response()->json(['count' => $productCount]);
    }
    public function getCategoryCount()
    {
        $categoryCount = Categories::count();

        return response()->json(['count' => $categoryCount]);
    }
}
