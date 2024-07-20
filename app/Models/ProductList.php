<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductList;
use App\Models\Categories;

class ProductList extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'categoryId',
        'item_code',
        'name',
        'image',
        'price',
        'description',
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'productId');
    }
    public function productlists()
    {
        return $this->hasMany(ProductList::class, 'productlistId');
    }
    public function categories()
    {
        return $this->hasMany(categories::class, 'categoryId');
    }
    
    public function category()
    {
        return $this->belongsTo(Categories::class, 'categoryId');
    }
}
