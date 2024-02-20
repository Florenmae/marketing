<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Product;


class CategoryController extends Controller
{
    public function createCategory(Request $request){
        $newCategory = new Categories();

        $newCategory->categoryId = $request->categoryId;
        $newCategory->categoryName = $request->categoryName;

        $res = $newCategory->save();

        return $res;
    }

    public function getCategories(){
        $categories = Categories::withCount([
            'products as product_count' => function (Builder $query) {
                $query->select(DB::raw('count(*)'))
                      ->from('products')
                      ->whereColumn('products.categoryId', '=', 'categories.categoryId');
            }
        ])->get();

        return $categories;
    }

    public function updateCategory(Request $request){
        $category = Categories :: findOrFail($request->editingCategoryId);

        $category->categoryId = $request->catPayload["categoryId"];
        $category->categoryName = $request->catPayload["categoryName"];

        $category->save();

        return $category;

    }

    public function deleteCategory(Request $request){
        // dd($request->id);
        $deleteCategory = Categories::find($request->categoryId);

        $res = $deleteCategory->delete();
        return $res;
    }


}
