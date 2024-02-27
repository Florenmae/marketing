<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $primaryKey = 'cartId';

    protected $fillable = [
        'cartId',
        'customerName',
        'productId',
        'productName',
        'image',
        'description',
        'price',
        'unitt',
        'qty',
        'total',

    ];

}
