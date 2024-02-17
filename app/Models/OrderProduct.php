<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderId',
        'customerId',
        'productId',
        'description',
        'price',
        'qty',
        'total',
        'paymentMethod',
        'balance',
        'changeAmount',
    ];

    public $timestamps = true;

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

}
