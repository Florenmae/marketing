<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'productId',
        'supplierId',
        'description',
        'qty',
        'approved_by',

    ];

     public function delivery()
    {
        return $this->hasMany(Delivery::class, 'transactionId');
    }

    
}
