<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use \stdClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            "name"=>'required|string|max:255',
            'email'=>"required|string|email|max:255|unique:users,email",
            'password'=>'required|string|min:3'
        ]);               
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)

        ]);
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json(['data'=>$user,'access_token'=>$token,'token_type'=>'Bearer']);
    }
    public function login(Request $request){
        if(!Auth::attempt($request->only("name","password"))){
            return response()->json(["message"=>"unauthorized"],401);
        }
        $user=User::where("name",$request["name"])->firstOrFail();
        $token=$user->createToken("auth_token")->plainTextToken;
        return response()->json([
            "message"=>$user->name,
            "accessToken"=>$token,
            'token_type'=>'Bearer',
            "user"=>$user
        ]);
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json(["message"=>"Logout complete"]);
    }
}
