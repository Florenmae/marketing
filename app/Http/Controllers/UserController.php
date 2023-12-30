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
        $newUser->role = $request->role;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = $request->password;

        $res = $newUser->save();

        return $res;
    }

    public function getUsers(){
        return User::all();
    }

    public function getUser(Request $request){
        if(User::where('id', $request->edit_id)->exist()){
            return User::find($request->edit_id);
        }else{
            return $data = (object)[
                "id" => 0,
                "name"=> "",
                "email"=>"",
                "role"=>"",
            ];
        }
    }

    public function updateUser(Request $request){
        $data = $request->data;
        $updateUser = User::find($data['id']);

        $updateUser->name = $data['name'];
        $updateUser->email = $data['email'];
        $updateUser->role = $data['role'];

        $res = $updateUser->save();
        return $res;
    }

    public function deleteUser(Request $request){
        // dd($request->id);
        $deleteUser = User::find($request->id);

        $res = $deleteUser->delete();
        return $res;
    }
}
