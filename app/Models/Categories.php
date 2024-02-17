<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Categories extends Model
{
    use HasFactory;
    protected  $fillable=[
        'categoryId',
        'categoryName',
        'product_count'

    ];

    protected $primarykey = 'cat_code';

    // protected $attributes = [
    //     'product_count' => 0,
    // ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_code', 'cat_code');
    }
}
