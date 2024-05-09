<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashRegistry;
use App\Models\CashAdmin;

class CashRegController extends Controller
{
    public function getCash()
    {
        $lastSavedCash = CashRegistry::latest()->first();
        
        return $lastSavedCash;
    }

    public function addCash(Request $request){
        $newCash = CashRegistry::create([
        'cashOnHand' => $request->cashOnHand
    ]);

   
    return $newCash;

    }

    public function remitToAdmin(Request $request)
    {
    
        // $request->validate([
        //     'cashOnHand' => 'required|numeric',
        // ]);
      
        $cashAdmin = new CashAdmin();
        $cashAdmin->amount = $request->input('cashOnHand');
        $cashAdmin->save();

        
        return response()->json(['message' => 'Cash remitted to admin successfully'], 200);
    }

}
