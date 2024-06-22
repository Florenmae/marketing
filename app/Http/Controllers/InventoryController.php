<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
     public function fetchInventories(){
        $userId = Auth::id();

        $inventory = Inventory::where('userId', $userId)
                            ->get();

        return $inventory;
    }
}
