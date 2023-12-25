<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class LoginController extends Controller
{
    //
    public function login(Request $request){
        if(User::where("email",$request->email)->exists()){
            $user = User::where("email",$request->email)->first();
            if(Hash::check($request->password, $user->password)){
                Auth::login($user);
                return response()->json(['message' => 'Login Successful'], 200);
            }else{
                return response()->json(['message' => 'Invalid'], 401);
            }
        }else{
            return response()->json(['message' => 'User not found'], 404);
        }

    }

    public function checkLogin(){
        // dd(Auth::check());
        return Auth::check();
    }

    public function logout() {
         return Auth::logout();
      }
}
