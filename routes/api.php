<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [AuthController::class, 'registerUser']);
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::get('/logout', [AuthController::class, 'logoutUser'])->middleware(['auth:sanctum', 'user.type:user']);
});

Route::group(['prefix' => 'librarian'], function () {
    Route::post('/login', [AuthController::class, 'loginLibrarian']);
    Route::get('/logout', [AuthController::class, 'logoutLibrarian'])->middleware(['auth:sanctum', 'user.type:librarian']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/me', [AuthController::class, 'me']);
});
