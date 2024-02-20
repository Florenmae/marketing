<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Categories extends Model
{
    use HasFactory;
    protected $primaryKey = 'categoryId';

    protected  $fillable=[
        'categoryId',
        'categoryName',
        'product_count'

    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'categoryId');
    }
}
