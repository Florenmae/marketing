<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = [
    'userId',
    'transactionId',
    'remarks',
    'status',
];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id');
    }

    public function products()
    {
        return $this->hasmany(Product::class, 'productId');
    }
}
