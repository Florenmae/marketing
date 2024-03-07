<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductList;
use App\Models\Delivery;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ProductListController extends Controller
{
    // public function getProductLists()
    // {
    //     $user = Auth::user();
    //     $productLists = $user->productLists;

    //     return $productLists;
    // }

    public function getProductLists()
    {   return ProductList::all();
        
    }
}
