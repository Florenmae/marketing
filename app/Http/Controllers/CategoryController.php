<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categories;
// use App\Models\Product;
use DB;

class CategoryController extends Controller
{
    public function createCategory(Request $request){
        $newCategory = new Categories();

        $newCategory->id = $request->id;
        $newCategory->categoryCode = $request->categoryCode;
        $newCategory->categoryName = $request->categoryName;

        $res = $newCategory->save();

        return $res;
    }

    public function getCategory(){
        return Categories::all();
    }

    public function deleteCategory(Request $request){
        // dd($request->id);
        $deleteCategory = Categories::find($request->id);

        $res = $deleteCategory->delete();
        return $res;
    }
}
