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
                'productId' => $transaction->productId,
                'userId' => $transaction->userId,
                'type' => $transaction->type,
                'qty' => $transaction->qty,
                'created_at' => Carbon::parse($transaction->created_at)->format('F d, Y'),
                'updated_at' => Carbon::parse($transaction->updated_at)->format('F d, Y'),
            ];
        });
        return response()->json($trans);
    }

    public function getTransactionId()
    {
         $product = Product::find($productId);
    if ($product) {
        $transaction = $product->transaction;
        if ($transaction) {
            return response()->json($transaction->id);
        }
    }

    return response()->json(null);
    }

}
