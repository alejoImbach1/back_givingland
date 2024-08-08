<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\UserController;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json(User::included()->find($request->user()->id));
    });

    Route::apiSingleton('user', UserController::class)->creatable()->only('update', 'destroy');

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::apiSingleton('profile', ProfileController::class)->creatable()->only('update', 'store');

    Route::put('/profile/delete-image', [ProfileController::class, 'deleteImage']);

    Route::post('/toggle-favorite', function (Request $request) {
        $request->user()->favorites()->toggle($request->post_id, ['created_at' => now()]);
    });

    Route::get('/favorites', function (Request $request) {
        return response()->json($request->user()->favorites()->with('images', 'location')->orderByPivot('created_at', 'desc')->get());
    });

    Route::post('/check-password', function (Request $request) {
        if(!Hash::check($request->password, $request->user()->password)){
            return response()->json(['message' => 'la contraseña actual no es correcta'], 400);
        }
    });
});

Route::apiResource('users', UserController::class)->only('show','store');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/google-login', [AuthController::class, 'googleLogin']);

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'sendEmail');
    Route::post('/reset-password', 'updatePassword');
});

Route::apiResource('profiles', ProfileController::class)->only('show');

Route::apiResource('social-media', SocialMediaController::class)->only('index');

Route::apiResource('posts', PostController::class);

Route::post('post/new-images', [PostController::class, 'storeNewImages']);

Route::apiResource('locations', LocationController::class)->only('index');

Route::apiResource('categories', CategoryController::class)->only('index');


Route::post('/p', function (Request $request) {
    return response()->json($request->image);
});
