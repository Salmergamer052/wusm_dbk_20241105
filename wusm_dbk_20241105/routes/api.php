<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/nuevousuario', [AuthController::class,"register"]);
Route::post('/Login', [AuthController::class,"login"]);
Route::post('/usuario', [AuthController::class,"me"])->middleware('auth:sanctum');