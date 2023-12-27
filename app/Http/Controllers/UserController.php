<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function createUser(Request $request){
        $newUser = new user();

        $newUser->id = $request->id;
        $newUser->role = $request->role;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = $request->password;

        $res = $newUser->save();

        return $res;
    }

    public function getUsers(){
        dd($request->id);
        return user::select()->where('id', Auth::id())->get();
    }


}
