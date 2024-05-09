<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegistry extends Model
{
    use HasFactory;

    protected $table = "cashregs";

    protected $fillable = [
        'transactionId',
        'cashOnHand',
        'type',
        'total',
        'paymentMethod',

    ];
}
