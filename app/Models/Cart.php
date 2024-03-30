<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customerId',
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
