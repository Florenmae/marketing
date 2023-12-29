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
        $newCategory->categoryCode = $request->categoryCode;
        $newCategory->categoryName = $request->categoryName;

        $res = $newCategory->save();

        return $res;
    }

    public function getCategory(){
        return Category::all();
    }
}
