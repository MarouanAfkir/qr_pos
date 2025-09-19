<?php


use App\Http\Controllers\API\PosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PosAuthController;
use App\Http\Controllers\OrderController;

Route::post('pos/login',  [PosAuthController::class, 'login'])->middleware('guest');
Route::post('pos/logout', [PosAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('pos/me', function (Request $request) {
    return $request->user();   // sanctum user (Bearer token)
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('cashiers', [PosAuthController::class, 'listCashiers']);

    Route::apiResource('orders', OrderController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::post('orders/{order}/payments', [OrderController::class, 'addPayment']);
    Route::patch('orders/{order}/status',  [OrderController::class, 'updateStatus']);
    Route::get('/pos/orders/today', [PosController::class, 'ordersToday'])->name('api.pos.orders.today');
});
