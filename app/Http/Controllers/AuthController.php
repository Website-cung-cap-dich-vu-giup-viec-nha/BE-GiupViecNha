<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register API - POST (name, email, password)
    public function register(Request $request){

        // Validation
        $request->validate([
            "name" => "required|string",
            "SDT" => 'required|phone_number|unique:users,SDT',
            "password" => "required|confirmed" // password_confirmation
        ]);

        // User model to save user in database
        User::create([
            "name" => $request->name,
            "SDT" => $request->SDT,
            "password" => bcrypt($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "data" => []
        ]);
    }

    // Login API - POST (email, password)
    public function login(Request $request){

        // Validation
        $request->validate([
            "SDT" => "required|phone_number",
            "password" => "required"
        ]);

        // Auth Facade
        // $token = Auth::attempt([
        //     "email" => $request->email,
        //     "password" => $request->password
        // ]);

        $token = auth()->attempt([
            "SDT" => $request->SDT,
            "password" => $request->password
        ]);

        if(!$token){

            return response()->json([
                "status" => false,
                "message" => "Invalid login details"
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "User logged in",
            "token" => $token,
            "expires_in" => auth()->factory()->getTTL() * 60
        ]);

    }

    // Profile API - GET (JWT Auth Token)
    public function profile(){

        //$userData = auth()->user();
        $userData = request()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "user" => $userData,
            "user_id" => request()->user()->id,
            "SDT" => request()->user()->SDT
        ]);
    }

    // Refresh Token API - GET (JWT Auth Token)
    public function refreshToken(){

        $token = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "Refresh token",
            "token" => $token,
            "expires_in" => auth()->factory()->getTTL() * 60
        ]);
    }

    // Logout API - GET (JWT Auth Token)
    public function logout(){

        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }
}
