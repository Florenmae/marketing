<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function createUser(Request $request){
        $newUser = new User();

        $newUser->id = $request->id;
        $newUser->roleId = $request->roleId;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = $request->password;

        $res = $newUser->save();

        return redirect('/user');
    }

    public function getUsers(Request $request) {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->get();   
        }



    public function updateUser(Request $request){
        // dd($request->userPayload["name"]);
        $user = User::findOrFail($request->editingUserId);

        $user->name = $request->userPayload["name"];
        $user->email = $request->userPayload["email"];
        $user->roleId = $request->userPayload["roleId"];

        $user->save();

        return $user;
    }


    public function deleteUser(Request $request){
        // dd($request->id);
        $deleteUser = User::find($request->id);

        $res = $deleteUser->delete();
        return $res;
    }

}
