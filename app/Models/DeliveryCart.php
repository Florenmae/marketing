<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCart extends Model
{
    use HasFactory;
    protected $table = "deliverycarts";
    protected $fillable = [
        'product_id',
        'productId',
        'qty',
        'price'
    ];
}
