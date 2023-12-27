<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
// use App\Models\Product;
use DB;

class CategoryController extends Controller
{
    public function createCategory(Request $request){
        $newCategory = new Category();

        $newCategory->id = $request->id;
        $newCategory->cat_code = $request->cat_code;
        $newCategory->categoryName = $request->categoryName;

        $res = $newCategory->save();

        return $res;
    }

    // public function productsIndex(){
    //     $category = DB::table('category')
    //         ->join('products', 'category.products', '=', 'products.product_code.category.number')
    //         ->select('category.*', 'products.*' )
    //         ->get();

    //     return view('category.products');
    // }
}
