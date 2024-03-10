<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\Productlist;
use App\Models\Delivery;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryId',
        'item_code',
        'name',
        'image',
        'userId',
        'price',
        'unit',
        'qty',
        'status',
        'description',
        'approved_by'
    ];

    // public function scopeRecent($query, $limit = 5)
    // {
    //     return $query->orderBy('created_at', 'description')->limit($limit);
    // }

    public function productlists()
    {
        return $this->belongsTo(ProductList::class, 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'id');
    }

    public function returnedProduct()
{
    return $this->hasOne(ReturnedProduct::class);
}
}
