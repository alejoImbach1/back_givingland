<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Utilily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

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

    public function googleLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $user->update(['username' => Utilily::generateUsername($user->name)]);
            $profile = $user->profile()->create(['google_avatar' => true]);
            $profile->image()->create(['url' => $request->avatar]);
        }
        $auth_token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(compact('auth_token'));
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Se cerró sesión']);
    }
}
