<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Product;

class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {
        $newCategory = new Categories();

        $newCategory->id = $request->id;
        $newCategory->name = $request->name;
        $newCategory->cat_code = $request->cat_code;

        return $newCategory->save();
    }

    public function getCategories(Request $request)
    {
        $search = $request->input('search');

        $categories = Categories::withCount([
            'products as product_count' => function (Builder $query) {
                $query->select(DB::raw('count(*)'))
                      ->from('products')
                      ->whereColumn('products.categoryId', '=', 'categories.id');
            }
        ]);

        if ($search) {
            $categories->where('name', 'like', '%' . $search . '%')
                       ->orWhere('cat_code', 'like', '%' . $search . '%');
        }

        return $categories->get();
    }

    public function updateCategory(Request $request)
    {
        $category = Categories::findOrFail($request->editingCategoryId);

        $category->name = $request->catPayload['name'];
        $category->cat_code = $request->catPayload['cat_code']; 

        $category->save();

        return $category;
    }

    public function deleteCategory(Request $request)
    {
        $deleteCategory = Categories::find($request->id);

        $res = $deleteCategory->delete();
        return $res;
    }
}
