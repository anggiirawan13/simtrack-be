<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\ShipperController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/dashboard', DashboardController::class);

Route::apiResource('/users', UserController::class);

Route::apiResource('/shippers', ShipperController::class);

Route::apiResource('/deliveries', DeliveryController::class);
Route::prefix('/deliveries')->group(function () {
    Route::get('/filter/status', [DeliveryController::class, 'filterByStatus']);
    Route::get('/generate', [DeliveryController::class, 'generateDeliveryNumber']);
});

Route::post('/auth/login', [AuthController::class, 'login']);
