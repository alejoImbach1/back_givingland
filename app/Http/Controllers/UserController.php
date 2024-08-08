<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Utilily;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|regex:/^[\p{L}\p{N}\sñÑáéíóúÁÉÍÓÚüÜ]+$/u',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/^(?=.*\d).{6,14}$/',
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
    public function update(Request $request)
    {
        if (!$request->hasAny(['name','username','email','password'])) {
            return response()->json(['message' => 'sin inputs'], 400);
        }

        $request->validate([
            'name' => 'sometimes|required|max:100|regex:/^[\p{L}\p{N}\sñÑáéíóúÁÉÍÓÚüÜ]+$/u',
            'username' => 'sometimes|required|unique:users,username|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'email' => 'sometimes|required|email|unique:users,email',
            'password' => 'sometimes|required|regex:/^(?=.*\d).{6,14}$/',
        ]);

        $message = $request->has('name') ? 'se cambió el nombre completo' : ($request->has('username') ?  'se cambió el nombre de usuario'
            :($request->has('email') ? 'se cambió el correo electrónico' : 'se cambió la contraseña'));

        if ($request->has('current_password')) {
            if (!Hash::check($request->current_password, $request->user()->password)) {
                $message = 'la contraseña actual no es correcta';
                return response()->json(compact('message'), 400);
            }
            $request->user()->update(['password' => Hash::make($request->password)]);
            return response()->json(compact('message'));
        }

        $request->user()->update($request->all());

        return response()->json(compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->password, $request->user()->password)) {
            $message = 'la contraseña actual no es correcta';
            return response()->json(compact('message'), 400);
        }
        $message = 'se eliminó su cuenta';
        $request->user()->delete();
        return response()->json(compact('message'));
    }
}
