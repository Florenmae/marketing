<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
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
        return $this->belongsTo(Order::class, 'customerId');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

}
