<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosAuthController;
use App\Http\Controllers\RestaurantMenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Keep ONLY the page views here (they can use web guard if you like)
Route::get('/pos', [RestaurantMenuController::class, 'index']);
Route::get('/pos/reports/daily', [RestaurantMenuController::class, 'dailyReportBlade'])
    ->name('pos.reports.daily');


// Admin login (session)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->middleware('auth:web');

// Session "me" endpoint for admin SPA
Route::get('/api/admin/me', fn(Request $r) => $r->user())
    ->middleware('auth:web');

// Lock down the admin UI
Route::get('/orders-admin', [RestaurantMenuController::class, 'getAdminPage'])
    ->middleware(['auth:web', 'admin']);


Route::middleware('auth:web')->prefix('admin')->group(function () {
    Route::get('/orders',  [OrderController::class, 'index']);   // list (supports your query params)
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::get('/cashiers', [PosAuthController::class, 'listCashiers']);
});

Route::get('/login', fn() => redirect('/admin/login'))->name('login');
