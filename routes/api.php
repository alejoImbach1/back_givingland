<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json(User::included()->find($request->user()->id));
    });
    
    Route::get('/logout',[AuthController::class,'logout']);
    
    Route::apiSingleton('profile',ProfileController::class)->creatable()->only('update','store');

    Route::post('toggle-favorite',function (Request $request){
        $request->user()->favorites()->toggle($request->post_id);
    });
});

// Route::get('/user/{user}',function ($userId){
//     return response()->json(User::included()->find($userId));
// });

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/google-login', [AuthController::class, 'googleLogin']);

// Route::post('/email-code', [RegisterController::class, 'generateCode']);

// Route::post('/verify-email-code',[RegisterController::class,'verifyCode']);

// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('profiles', ProfileController::class)->only('show');

Route::apiResource('social-media', SocialMediaController::class)->only('index');

Route::apiResource('posts',PostController::class);

Route::apiResource('locations',LocationController::class)->only('index');

Route::apiResource('categories',CategoryController::class)->only('index');

Route::post('post/new-images',[PostController::class,'storeNewImages']);

Route::apiResource('users',UserController::class)->except('index');

Route::post('/p',function(Request $request){
    return response()->json($request->image);
});

