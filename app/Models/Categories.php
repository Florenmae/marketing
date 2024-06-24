<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductList;


class Categories extends Model
{
    use HasFactory;

    protected  $fillable=[
        'id',
        'name',
        'cat_code',
        'product_count'

    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'categoryId');
    }
    public function productList()
    {
        return $this->hasMany(ProductList::class, 'categoryId');
    }
    
}
