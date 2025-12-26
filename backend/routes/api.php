<?php

use App\Http\Controllers\AuthController;
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





//Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/request-password-reset', [AuthController::class, 'requestPasswordReset']);
Route::put('/user/password-with-token', [AuthController::class, 'resetPasswordWithToken']);


Route::middleware('auth:sanctum')->group(function () {

    Route::delete('/user', [AuthController::class, 'deleteUser']);

    Route::get('/user', [AuthController::class, 'show']);

    Route::post('/user/deposit-intent', [AuthController::class, 'depositIntent']);
    Route::post('/user/deposit-confirm', [AuthController::class, 'depositConfirm']);
    Route::post('/link-with-discord', [AuthController::class, 'linkWithDiscord']);

    Route::put('/me', [AuthController::class, 'update']);
    Route::put('/user/password', [AuthController::class, 'updatePassword']);
});
