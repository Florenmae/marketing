<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashRegistry;
use App\Models\CashAdmin;
use App\Models\CashLogs;
use Carbon\Carbon;


class CashRegController extends Controller
{
    public function getCash()
    {
        $lastSavedCash = CashRegistry::latest()->first();
        
        return $lastSavedCash;
    }

    public function addCash(Request $request){

        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $newCash = CashRegistry::create([
        'amount' => $request->amount
    ]);

    return $newCash;

    }

    public function remitToAdmin(Request $request)
    {
    
        $request->validate([
            'amount' => 'required|numeric',
        ]);
      
        $cashAdmin = new CashAdmin();
        $cashAdmin->amount = $request->input('amount');
        $cashAdmin->save();

        
        return response()->json(['message' => 'Cash remitted to admin successfully'], 200);
    }

    public function getCashLogs(){
        $cashlogs = CashLogs::all();

       $cashlogs = $cashlogs->map(function($log) {
            $log->formatted_date = Carbon::parse($log->created_at)->format('F d, Y');
            return $log;
        });

        return response()->json($cashlogs);

    }

    public function getCashadmins(){
        $cashadmins = CashAdmin::all();

       $cashadmins = $cashadmins->map(function($remit) {
            $remit->formatted_date = Carbon::parse($remit->created_at)->format('F d, Y');
            return $remit;
        });

        return response()->json($cashadmins);

    }

}
