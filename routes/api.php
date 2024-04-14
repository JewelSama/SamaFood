<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\VendorController;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    Route::post('/buyer/order/new', [OrderController::class, 'create']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/vendors/all', [VendorController::class, 'getVendors']);
    Route::post('/vendor/menu/new/{id}', [MenuController::class, 'create']);
    Route::get('/vendor/menu/{id}', [MenuController::class, 'getVendorMenu']);
    Route::put('/vendor/menu/{id}', [MenuController::class, 'editMenu']);
    Route::get('/vendor/orders', [OrderController::class, 'getVendorOrders']);
    Route::put('/vendor/orders/{id}', [OrderController::class, 'updateOrderStatus']);
});

// Route::get('send-mail/{id}', function ($id) {
//     $data = [
//         'title'=> "Your Order has been accepted!",
//         'content' => 'Open the SamaFood app to learn more.'
//     ];
 
//     Mail::to('jameshopejew@gmail.com')->send(new OrderStatusMail($data));
// });
