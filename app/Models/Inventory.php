<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'productId',
        'productlistId',
        'categoryId',
        'userId',
        'item_code',
        'image',
        'unit',
        'stocks',
        'description',
        'created_at',
        'updated_at'
    ];
}
