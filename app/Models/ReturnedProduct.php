<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ReturnedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'productlistId',
        'userId',
        'item_code',
        'qty',
        'description',
        'created_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productlistId', 'id');
    }

}
