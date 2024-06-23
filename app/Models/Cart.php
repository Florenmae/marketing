<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'productId',
        'customerId',
        'productlistId',
        'image',
        'description',
        'price',
        'unit',
        'qty',
        'total',

    ];

    public function product()
{
    return $this->belongsTo(Product::class, 'productId');
}

}
