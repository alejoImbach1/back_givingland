<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMailable;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $email = $request->email;

        $tokenRepository = new DatabaseTokenRepository(DB::connection(), new BcryptHasher(), 'password_reset_tokens', 'bcrypt ');

        $token =  $tokenRepository->create(Password::getUser(compact('email')));

        $reset_url = URL::query(env('front_url') . '/reset-password/' . $token, compact('email'));

        $message = 'se envió un correo electrónico con las instrucciones';

        return response()->json(compact('token', 'reset_url', 'message'));

        // Mail::to($email)->send(new ForgotPasswordMailable(User::where(compact('email'))->first(),$reset_url));

        // return response()->json(compact('token','message'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json(['message' => __($status)], $status === Password::PASSWORD_RESET ? 200 : 400);
    }
}
