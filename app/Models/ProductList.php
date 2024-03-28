<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Categories;

class ProductList extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'userId',
        'categoryId',
        'item_code',
        'name',
        'image',
        'price',
        'description',
    ];

    // protected $table = 'productLists';

    public function products()
    {
        return $this->hasMany(Product::class, 'productId');
    }
    public function categories()
    {
        return $this->hasMany(categories::class, 'categoryId');
    }
    
    public function category()
    {
        return $this->belongsTo(Categories::class, 'id');
    }
}
