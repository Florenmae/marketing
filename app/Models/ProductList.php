<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductList extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'id',
    //     'userId',
    //     'item_code',
    //     'name',
    //     'image',
    //     'price',
    //     'description',
    // ];

    protected $table = 'productLists';

    public function products()
    {
        return $this->hasMany(Product::class, 'productId');
    }
}
