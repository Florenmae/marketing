<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function fetchTransactions (Request $request){
        $transactions = Transaction::all();

        $trans = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'name' => $transaction->name,
                'supplier' => $transaction->supplier,
                'description' => $transaction->description,
                'qty' => $transaction->qty,
                'created_at' => Carbon::parse($transaction->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($transaction->updated_at)->format('Y-m-d'),
            ];
        });
        return response()->json($trans);
    }

}
