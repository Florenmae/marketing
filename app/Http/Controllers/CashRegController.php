<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashRegistry;

class CashRegController extends Controller
{
    public function getCash()
    {
        return CashRegistry::all();

    }
    public function addCash(Request $request){
        $newCash = CashRegistry::create([
        'cashOnHand' => $request->cashOnHand
    ]);

   
    return $newCash;

    }

}
