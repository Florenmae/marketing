<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class SignupController extends Controller
{
    public function signup(Request $request){
        if(User::where("email",$request->email)->exists()){
        return;
    }
    $user = new User;

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->password = Hash::make($request->password);

    $user->save();
    }


}
