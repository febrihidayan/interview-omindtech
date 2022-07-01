<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $request->validate([
            "email" => "required|min:3|email|exists:users,email",
            "password" => "required|min:6"
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                "status" => "Failed",
                "message" => "Unauthorised.",
            ], 401);
        }

        $user = Auth::user();
        $user['token'] =  $user->createToken('app')->plainTextToken;

        return response()->json([
            "status" => "Success",
            "message" => "User register successfully.",
            "data" => $user,
        ]);
    }
    
    public function Register(Request $request)
    {
        $request->validate([
            "name" => "required|min:3",
            "email" => "required|min:3|email|unique:users,email",
            "password" => "required|min:6"
        ]);

        $request["password"] = bcrypt($request->password);

        $user = User::create($request->all());

        return response()->json([
            "status" => "Success",
            "message" => "User register successfully.",
            "data" => $user,
        ]);
    }

    public function Logout(Request $request)
    {
        $user = Auth::user();

        $user->tokens()->delete();

        return response()->json([
            "status" => "Success",
            "message" => "logout successfully.",
        ]);
    }
}
