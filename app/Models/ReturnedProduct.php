<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedProduct extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $fillable = [
        'item_code',
        'name',
=======
    // protected $table = "returnedProducts";

    protected $fillable = [
        'product_id',
        'name',
        'item_code',
>>>>>>> 56326e53543457e0ddd35690d4b2a3ea39d8ac5b
        'supplier',
        'qty',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
