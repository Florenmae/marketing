<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'customerName',

    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customerId');
    }
}
