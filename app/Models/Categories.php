<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Inventory;

class Categories extends Model
{
    use HasFactory;

    protected  $fillable=[
        'categoryId',
        'categoryName',
        'product_count'

    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'categoryId');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'categoryId');
    }
    
}
