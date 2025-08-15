<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\RestaurantMenuController;
use Illuminate\Support\Facades\Route;

/* Static page you already had */

Route::get('/', [LandingController::class, 'index']);
// Route::get('/rihla', function() {
//     return view('rihla');
// });
Route::get('/voyage', function() {
    return view('voyage');
});

Route::get('/menu/{uuid}', [RestaurantMenuController::class, 'show'])
    ->whereUuid('uuid')    
    ->name('menu.show');

Route::get('/menu/{uuid}/agent', [RestaurantMenuController::class, 'showAgentMode'])
    ->whereUuid('uuid')    
    ->name('menu.agent.show');
