<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RestaurantMenuController extends Controller
{

    public function index(Request $request)
    {
        $baseUrl = config('services.qrevo.base_url');
        $token   = config('services.qrevo.token');
        $uuid    = config('services.qrevo.business_id');

        $companyInfo = Http::withToken($token)
            ->acceptJson()
            ->withOptions(['verify' => false])
            ->withHeaders(['Accept-Language' => 'en'])
            ->get("{$baseUrl}/restaurants/{$uuid}/info")
            ->throw()
            ->json();
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
        //Get users pos_code to send it to the blade
        $users = DB::table('users')->where('is_admin',0)->select('pos_code')->get();

        /* -------- Render Blade -------- */
        return view('pos', [
            'articles'   => $articles   ?? [],
            'categories' => $categories ?? [],
            'company'    => $companyInfo['data'] ?? [],
            'users'      => $users      ?? [],
        ]);
    }
    // getAdminPage
    public function getAdminPage(Request $request)
    {
        /* -------- Render Blade -------- */
        return view('backoffice');
    }
    public function dailyReportBlade()
    {
        // Pass restaurant info if you need it for the header
        $restaurant = [
            'name'    => config('app.name', 'Restaurant'),
            'address' => '',
            'logo'    => '/assets/img/logo/logo.svg',
            'settings' => ['tagline' => 'Fresh • Local • Delicious'],
        ];
        return view('pos-daily-report', compact('restaurant'));
    }
}
