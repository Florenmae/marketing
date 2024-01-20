<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Product extends Model
{
    use HasFactory;
    // protected $table = "products";
    protected $fillable = [
        'cat_code',
        'item_code',
        'name',
        'supplier',
        'price',
        'qty',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'cat_code');
    }

    public function returnedProduct()
{
    return $this->hasOne(ReturnedProduct::class);
}
}
