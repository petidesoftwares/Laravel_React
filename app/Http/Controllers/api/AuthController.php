<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = $request->validate([
            'name'=>'required',
            'email'=>'required|max:191|email|unique:users,email',
            'password'=>'required|min:6',
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        $token = $user->createToken($user->email.'_Token')->plainTextToken;
        return response()->json([
            'status'=>200,
            'token'=>$token,
            'message'=>"Registration successful"
        ]);
    }
}
