<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RestaurantMenuController extends Controller
{

    public function index(Request $request)
    {
        $baseUrl = config('services.qrevo.base_url');
        $token   = config('services.qrevo.token');
        $uuid    = config('services.qrevo.business_id');

        $articles = Http::withToken($token)
            ->acceptJson()
            ->withOptions(['verify' => false])
            ->withHeaders(['Accept-Language' => 'en'])
            ->get("{$baseUrl}/restaurants/{$uuid}/articles")
            ->throw()
            ->json();

        // Fetch categories (normalize on the frontend)
        $categories = Http::withToken($token)
            ->acceptJson()
            ->withOptions(['verify' => false])
            ->withHeaders(['Accept-Language' => 'fr'])
            ->get("{$baseUrl}/restaurants/{$uuid}/categories")
            ->throw()
            ->json();

        /* -------- Render Blade -------- */
        return view('pos', [
            'articles'   => $articles   ?? [],
            'categories' => $categories ?? [],
        ]);
    }
    // getAdminPage
    public function getAdminPage(Request $request)
    {
        /* -------- Render Blade -------- */
        return view('backoffice');
    }
}
