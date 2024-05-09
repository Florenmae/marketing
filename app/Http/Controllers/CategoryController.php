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

        $newCategory->id = $request->id;
        $newCategory->name = $request->name;
        $newCategory->cat_code = $request->cat_code;

        return $newCategory->save();

    }

    public function getCategories(){
        $categories = Categories::withCount([
            'products as product_count' => function (Builder $query) {
                $query->select(DB::raw('count(*)'))
                      ->from('products')
                      ->whereColumn('products.id', '=', 'categories.id');
            }
        ])->get();

        return $categories;
    }

    public function updateCategory(Request $request){
        $category = Categories :: findOrFail($request->editingCategoryId);

        $category->name = $request->catPayload["name"];

        $category->save();

        return $category;

    }

    public function deleteCategory(Request $request){
        // dd($request->id);
        $deleteCategory = Categories::find($request->id);

        $res = $deleteCategory->delete();
        return $res;
    }


}
