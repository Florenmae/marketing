<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_code',
        'name',
        'supplier',
        'qty',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
