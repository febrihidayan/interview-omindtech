<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\DashboardController;
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


Route::controller(AuthController::class)->group(function() {
    Route::post("/register", "register");
    Route::post("/login", "login");
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
    
    Route::get('/dashboard', DashboardController::class);

    Route::post("/logout", [AuthController::class, "logout"]);
});
