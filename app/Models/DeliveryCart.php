<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class DeliveryCart extends Model
{
    use HasFactory;
    protected $table = "deliverycarts";
    protected $fillable = [
        'productId',
        'productlistId',
        'qty',
        'price'
    ];

    public function product()
{
    return $this->belongsTo(Product::class, 'productId');
}

}
