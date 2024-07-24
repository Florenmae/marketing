<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function fetchTransactions(Request $request) {
    
    $userId = Auth::id();

    $transactions = Transaction::where('userId', $userId)->get();

    $trans = $transactions->map(function ($transaction) {
        return [
            'id' => $transaction->id,
            'productlistId' => $transaction->productlistId,
            'userId' => $transaction->userId,
            'roleId' => $transaction->roleId,
            'type' => $transaction->type,
            'qty' => $transaction->qty,
            'totalprice' => $transaction->totalprice,
            'created_at' => Carbon::parse($transaction->created_at)->format('F d, Y'),
            'updated_at' => Carbon::parse($transaction->updated_at)->format('F d, Y'),
        ];
    });

    return response()->json($trans);
}


    public function getTransactionId()
    {
         $product = Product::find($productlistId);
    if ($product) {
        $transaction = $product->transaction;
        if ($transaction) {
            return response()->json($transaction->id);
        }
    }

    return response()->json(null);
    }

}
