<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customerId',
        'userId',
        'productlistId',
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

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

}
