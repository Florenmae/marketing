<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashLogs extends Model
{
    use HasFactory;

    protected $table = "cashlogs";

    protected $fillable = [
        'transactionId',
        'inflow',
        'outflow',
    ];
}

