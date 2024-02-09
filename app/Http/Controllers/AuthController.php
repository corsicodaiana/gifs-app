<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function createUser(CreateUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Usuario creado',
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ],200);
    }

    public function loginUser(LoginRequest $request)
    {
        if(!Auth::attempt($request->only(['email','password']))){
            return response()->json([
                'status' => false,

            ],401);
        }
        
        $user = User::where('email',$request->email)->first();

        return response()->json([
            'status' => true,
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ],200);
    }
}
