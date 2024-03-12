<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
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

// auth 
Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [ProfileController::class, 'getProfile']);
    Route::put('/user/profile/{id}', [ProfileController::class, 'updateProfile']);
    Route::get('/user/orders/{id}', [OrderController::class, 'getUserOrders']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/restaurants', [RestaurantController::class, 'getRestaurants']);
    Route::get('/restaurant/menu/{id}', [MenuController::class, 'getRestaurantMenu']);
});
