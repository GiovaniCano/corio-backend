<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::delete('user/delete-account', [UserController::class, 'destroy'])->name('user.destroy')->middleware(['auth:web', 'password.confirm']);
Route::put('user/profile-information', [UserController::class, 'update'])->name('user-profile-information.update')->middleware('auth:web');

Route::get('avatars', [UserController::class, 'avatars'])->name('avatars')->middleware('auth:web');

Route::get('auth-status', function(Request $request) {
    return auth()->check() 
            ? response()->json($request->user()) 
            : response()->json(null, 204);
});

// Route::get('_test', function() {
//     return response()->json('hola');
// });

Route::fallback(fn() => response()->json('Not Found', 404));