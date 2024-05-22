<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DichVuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post("auth/register", [AuthController::class, "register"]);
Route::post("auth/login", [AuthController::class, "login"]);
Route::post("user/{id}", [AuthController::class, "updateUser"]);
Route::group([
    "prefix" => "auth",
    "middleware" => ["auth:api"]
], function(){
    Route::get("profile", [AuthController::class, "profile"]);
    Route::get("refresh-token", [AuthController::class, "refreshToken"]);
    Route::get("logout", [AuthController::class, "logout"]);

});


Route::resource('dichvu', DichVuController::class);
