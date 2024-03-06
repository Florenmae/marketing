<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoryId',
        'item_code',
        'productId',
        'name',
        'userId',
        'price',
        'unit',
        'stocks',
        'status',
        'description',
        'approved_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'id');
    }

    public function returnedProduct()
    {
        return $this->hasOne(ReturnedProduct::class);
    }
}
