<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCart extends Model
{
    use HasFactory;
    protected $table = "deliverycarts";
    protected $fillable = [
        'productId',
        'qty',
        'price'
    ];
}
