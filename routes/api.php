<?php

use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
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
Route::post("roles",[RoleController::class,"store"])->middleware(["auth:sanctum","superadmin"]);
Route::delete("roles/{role}",[RoleController::class,"destory"])->middleware(["auth:sanctum","superadmin"]);
Route::put("roles/{role}",[RoleController::class,"update"])->middleware(["auth:sanctum","superadmin"]);

// categories
Route::get("categories",[CategoryController::class, "show"]);
Route::post("categories",[CategoryController::class,"store"])->middleware(["auth:sanctum","admin"]);
Route::put("categories/{category}",[CategoryController::class, "update"])->middleware(["auth:sanctum","admin"]);
Route::delete("categories/{category}",[CategoryController::class, "delete"])->middleware(["auth:sanctum","admin"]);

