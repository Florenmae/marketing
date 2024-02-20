<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'productId';

    protected $fillable = [
        'categoryId',
        'item_code',
        'productName',
        'image',
        'supplierId',
        'price',
        'unit',
        'qty',
        'status',
        'description',
    ];

    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('created_at', 'description')->limit($limit);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'categoryId');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplierId');
    }

    public function returnedProduct()
{
    return $this->hasOne(ReturnedProduct::class);
}
}
