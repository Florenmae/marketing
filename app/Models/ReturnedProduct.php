<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedProduct extends Model
{
    use HasFactory;
    // protected $table = "returnedProducts";

    protected $fillable = [
        'product_id',
        'name',
        'item_code',
        'supplier',
        'qty',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
