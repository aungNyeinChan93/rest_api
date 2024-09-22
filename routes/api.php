<?php

use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// user
Route::get("users",[UserController::class,"show"]);
Route::post("register",[UserController::class,"register"]);
Route::post("login",[UserController::class,"login"]);
Route::post("users/{user}/update-profile",[UserController::class,"updateProfile"])->middleware("auth:sanctum");


// role
Route::get("roles",[RoleController::class,"show"]);
Route::post("roles",[RoleController::class,"store"]);
Route::delete("roles/{role}",[RoleController::class,"destory"]);
Route::put("roles/{role}",[RoleController::class,"update"]);

