<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\RestaurantMenuController;
use Illuminate\Support\Facades\Route;

/* Static page you already had */

Route::get('/', [LandingController::class, 'index']);

Route::get('/menu/{uuid}', [RestaurantMenuController::class, 'show'])
    ->whereUuid('uuid')    
    ->name('menu.show');
