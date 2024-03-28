<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\VendorController;
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
Route::post('/buyer/register', [AuthController::class, 'register']);
Route::post('/vendor/register', [AuthController::class, 'vendorRegister']);

Route::post('/buyer/login', [AuthController::class, 'login']);
Route::post('/vendor/login', [AuthController::class, 'vendorLogin']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/buyer/profile', [ProfileController::class, 'getProfile']);
    Route::put('/buyer/profile/{id}', [ProfileController::class, 'updateProfile']);
    Route::get('/buyer/orders/{id}', [OrderController::class, 'getUserOrders']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/vendors', [VendorController::class, 'getVendors']);
    Route::get('/vendor/menu/{id}', [MenuController::class, 'getRestaurantMenu']);
});
