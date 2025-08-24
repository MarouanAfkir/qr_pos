<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\RestaurantMenuController;
use Illuminate\Support\Facades\Route;

/* Static page you already had */

Route::get('/', [LandingController::class, 'index']);
//blog
Route::get('/privacy', function() {
    return view('pages.privacy');
});
// Route::get('/blog', function() {
//     return view('pages.blog');
// });
// Route::get('/rihla', function() {
//     return view('rihla');
// });
// Route::get('/bakery', function() {
//     return view('bakery');
// });
// Route::get('/bakery_2', function() {
//     return view('bakery_2');
// });
// Route::get('/bakery_2_hero_2', function() {
//     return view('bakery_2_hero_2');
// });
// Route::get('/bakery_blog', function() {
//     return view('bakery_blog');
// });
// Route::get('/bakery_blog_post', function() {
//     return view('bakery_blog_post');
// });
// Route::get('/bakery_story', function() {
//     return view('bakery_story');
// });
// Route::get('/bakery_menu', function() {
//     return view('bakery_menu');
// });

Route::get('/menu/{uuid}', [RestaurantMenuController::class, 'show'])
    ->whereUuid('uuid')    
    ->name('menu.show');

Route::get('/menu/{uuid}/agent', [RestaurantMenuController::class, 'showAgentMode'])
    ->whereUuid('uuid')    
    ->name('menu.agent.show');
