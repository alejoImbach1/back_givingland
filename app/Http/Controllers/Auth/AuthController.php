<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // $request->session()->regenerate();
        $user = auth()->user();
        $auth_token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(compact('auth_token'));
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Se cerró sesión']);
    }
}
