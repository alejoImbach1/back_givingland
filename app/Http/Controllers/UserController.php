<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Utilily;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', only: ['update', 'destroy']),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|regex:/^[\p{L}\p{N}\sñÑáéíóúÁÉÍÓÚüÜ]+$/u',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|regex:/^(?=.*\d).{6,14}$/',
        ]);

        $request->merge([
            'password' => (Hash::make($request->password)),
            'username' => Utilily::generateUsername($request->name)
        ]);


        $user = User::create($request->all());

        $profile = $user->profile()->create();

        $profile->image()->create(['url' => 'users_profile_images/default.svg']);

        $auth_token = $user->createToken('auth_token')->plainTextToken;

        $user = User::with('profile')->find($user->id);

        $message = 'se registró y se inició sesión';

        return response()->json(compact('auth_token', 'user', 'message'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userIndex)
    {
        $user = User::included()->where('id', $userIndex)->orWhere('username', $userIndex)->first();
        if (!$user) {
            return response()->json(['message' => 'usuario no encontrado'], 404);
        }
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
