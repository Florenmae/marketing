<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'name',
        'image',
        'description',
        'price',
        'quantity',
        'total',
    ];

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

}
