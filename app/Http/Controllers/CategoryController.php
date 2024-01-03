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

    public function updateCategory(Request $request, $id)
{
    $request->validate([
        'categoryCode' => 'required|string|max:255',
        'categoryName' => 'required|string|max:255',
    ]);

    $category = $id ? Categories::findOrFail($id) : new Categories;

    $category->categoryCode = $request->input('categoryCode');
    $category->categoryName = $request->input('categoryName');

    $category->save();

    return $category->fresh(); // Optionally return the fresh instance of the updated category
}


    public function deleteCategory(Request $request){
        // dd($request->id);
        $deleteCategory = Categories::find($request->id);

        $res = $deleteCategory->delete();
        return $res;
    }
}
