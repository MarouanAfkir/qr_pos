<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RestaurantMenuController extends Controller
{
    /**
     * Display a digital-menu page for a given restaurant UUID.
     *
     * URL examples:
     *  /menu/9682f999-ac7b-4ecb-bea9-6ea3e4483874            → resources/views/welcome.blade.php
     *  /menu/0d0f4eab-0280-4b37-bc02-08584486c477/welcome7   → resources/views/welcome7.blade.php
     *
     * @param  string  $uuid       Restaurant UUID from QResto
     */
    public function show(Request $request, string $uuid)
    {
        $locale  = $request->get('lang', 'en');
        $template = $request->get('template', 'welcome7');
        $baseUrl = config('services.qresto.base_url', 'https://qresto.foxirent.com/api');
        $token   = config('services.qresto.token');

        /* -------- Fetch available languages -------- */
        $languages = Http::withToken($token)
            ->withOptions(['verify' => false])
            ->get("{$baseUrl}/restaurants/{$uuid}/languages")
            ->throw()
            ->json();

        /* -------- Fetch menu + items in requested locale -------- */
        $items = Http::withToken($token)
            ->withOptions(['verify' => false])
            ->withHeaders(['Accept-Language' => $locale])
            ->get("{$baseUrl}/restaurants/{$uuid}/items")
            ->throw()
            ->json();
        /* -------- Ensure the requested view exists -------- */
        if (! view()->exists($template)) {
            abort(404, "View [{$template}] not found.");
        }

        /* -------- Render Blade -------- */
        return view($template, [
            'restaurant'       => $items['restaurant']        ?? null,
            'currency'         => 'Dh',                       // change if needed
            'languages'        => $languages['data']['languages']       ?? [],
            'default_language' => $languages['data']['default_language'] ?? null,
            'menu'             => $items['menu']              ?? null,
            'categories'       => $items['categories']        ?? [],
        ]);
    }


    public function showOld(Request $request)
    {
        /* ───────── Locale & query param ───────── */
        $default_language = $request->query('lang', 'en');

        /* ───────── UI language list (static) ───────── */
        $languages = [
            ['code' => 'en', 'name' => 'English'],
            ['code' => 'fr', 'name' => 'Français'],
            ['code' => 'ar', 'name' => 'العربية'],
        ];

        /* ───────── Café metadata ───────── */
        $restaurant = [
            'name'    => 'Moca Coffee Shop',
            'logo'    => 'https://coffeemoca.ma/assets/images/logo/logo.png',   // drop a logo here or swap the path
            'address' => 'Av. des F.A.R, Nador',
            'phone_number_1' => '+212 600-123456',
            'phone_number_2' => '+212 600-654321',
            'settings' => [
                'tagline' => 'Specialty Coffee • Creative Drinks',
            ],
        ];

        /* ───────── Menu headline ───────── */
        $menu = [
            'name'        => 'Moca Summer ’25 Menu',
            'description' => 'Signature coffees, iced specials & sweet treats.',
        ];

        /* ───────── Categories & items (prices in DH) ───────── */
        $categories = [

            /** 1. Espresso Bar **/
            [
                'name'  => 'Espresso Bar',
                'items' => [
                    ['name' => 'Espresso',        'description' => 'Single, bold shot of Arabica.',                            'price' => 8.00,  'sale_price' => null, 'image' => 'assets/img/menu/espresso.png'],
                    ['name' => 'Doppio',          'description' => 'Double espresso for extra kick.',                          'price' => 10.00, 'sale_price' => null, 'image' => 'assets/img/menu/doppio.png'],
                    ['name' => 'Bombón',          'description' => 'Espresso layered with sweet condensed milk.',              'price' => 15.00, 'sale_price' => null, 'image' => 'assets/img/menu/bombon.png'],
                    ['name' => 'Americano',       'description' => 'Espresso & hot water, classic & smooth.',                  'price' => 12.00, 'sale_price' => null, 'image' => 'assets/img/menu/americano.png'],
                    ['name' => 'Cortado',         'description' => 'Equal parts espresso & steamed milk.',                     'price' => 12.00, 'sale_price' => null, 'image' => 'assets/img/menu/cortado.png'],
                ],
            ],

            /** 2. Milk Coffees **/
            [
                'name'  => 'Milk Coffees',
                'items' => [
                    ['name' => 'Cappuccino',                'description' => 'Timeless Italian 1-1-1 ratio.',                  'price' => 14.00, 'sale_price' => null, 'image' => 'assets/img/menu/cappuccino.png'],
                    ['name' => 'Cappuccino Viennois',       'description' => 'Topped with whipped cream—chocolate or caramel.', 'price' => 18.00, 'sale_price' => null, 'image' => 'assets/img/menu/capp_viennois.png'],
                    ['name' => 'Coffee Latte',              'description' => 'Silky steamed milk & espresso.',                 'price' => 18.00, 'sale_price' => null, 'image' => 'assets/img/menu/latte.png'],
                    ['name' => 'Spanish Latte',             'description' => 'Espresso, milk & a touch of condensed milk.',    'price' => 15.00, 'sale_price' => null, 'image' => 'assets/img/menu/spanish_latte.png'],
                    ['name' => 'Flat White',                'description' => 'Double espresso + thin micro-foam.',             'price' => 17.00, 'sale_price' => null, 'image' => 'assets/img/menu/flat_white.png'],
                    ['name' => 'Mocha',                     'description' => 'Espresso, chocolate & steamed milk.',            'price' => 15.00, 'sale_price' => null, 'image' => 'assets/img/menu/mocha.png'],
                ],
            ],

            /** 3. Iced Coffee Specials **/
            [
                'name'  => 'Iced Coffee Specials',
                'items' => [
                    ['name' => 'Iced Americano',      'description' => 'Chilled espresso & filtered water.',                   'price' => 17.00, 'sale_price' => null, 'image' => 'assets/img/menu/ice_americano.png'],
                    ['name' => 'Iced Latte',          'description' => 'Espresso + cold milk over ice.',                       'price' => 17.00, 'sale_price' => null, 'image' => 'assets/img/menu/ice_latte.png'],
                    ['name' => 'Iced Cappuccino',     'description' => 'Foamy & refreshing—the capp you can sip cold.',       'price' => 19.00, 'sale_price' => null, 'image' => 'assets/img/menu/ice_cappuccino.png'],
                    ['name' => 'Moca Iced Coffee',    'description' => 'K-style whipped iced coffee—the café’s namesake.',    'price' => 20.00, 'sale_price' => null, 'image' => 'assets/img/menu/moca_iced.png'],
                    ['name' => 'Iced Spanish Latte',  'description' => 'Sweet, creamy & seriously chill.',                    'price' => 23.00, 'sale_price' => null, 'image' => 'assets/img/menu/iced_spanish.png'],
                    ['name' => 'Iced Coffee Lotus',   'description' => 'Lotus biscuit flavour, creamy milk, crushed ice.',    'price' => 20.00, 'sale_price' => null, 'image' => 'assets/img/menu/lotus_iced.png'],
                ],
            ],

            /** 4. Chocolate & Matcha **/
            [
                'name'  => 'Chocolate & Matcha',
                'items' => [
                    ['name' => 'Hot Chocolate',          'description' => 'Creamy cocoa comfort.',                      'price' => 12.00, 'sale_price' => null, 'image' => 'assets/img/menu/hot_choc.png'],
                    ['name' => 'Dark Hot Chocolate',     'description' => 'Intense 70 % cocoa, steamed milk.',           'price' => 16.00, 'sale_price' => null, 'image' => 'assets/img/menu/dark_choc.png'],
                    ['name' => 'Iced Chocolate',         'description' => 'Cold, rich & instantly uplifting.',           'price' => 13.00, 'sale_price' => null, 'image' => 'assets/img/menu/iced_choc.png'],
                    ['name' => 'Matcha Latte',           'description' => 'Ceremonial-grade matcha & velvety milk.',     'price' => 28.00, 'sale_price' => null, 'image' => 'assets/img/menu/matcha_latte.png'],
                    ['name' => 'Iced Matcha Latte',      'description' => 'Cool, earthy & energising.',                 'price' => 25.00, 'sale_price' => null, 'image' => 'assets/img/menu/iced_matcha.png'],
                    ['name' => 'Iced Matcha Strawberry', 'description' => 'Matcha meets sweet berries.',                'price' => 30.00, 'sale_price' => null, 'image' => 'assets/img/menu/matcha_strawberry.png'],
                ],
            ],

            /** 5. Milkshakes & Frappés **/
            [
                'name'  => 'Milkshakes & Frappés',
                'items' => [
                    ['name' => 'Strawberry Milkshake',   'description' => 'Classic, creamy & berry-packed.',             'price' => 25.00, 'sale_price' => null, 'image' => 'assets/img/menu/shake_strawberry.png'],
                    ['name' => 'Oreo Milkshake',         'description' => 'Cookies-and-cream overload.',                 'price' => 30.00, 'sale_price' => null, 'image' => 'assets/img/menu/shake_oreo.png'],
                    ['name' => 'Kinder Bueno Milkshake', 'description' => 'Hazelnut-choco bliss.',                       'price' => 30.00, 'sale_price' => null, 'image' => 'assets/img/menu/shake_kinder.png'],
                    ['name' => 'Oreo Frappuccino',       'description' => 'Blended ice coffee with Oreo crunch.',        'price' => 35.00, 'sale_price' => null, 'image' => 'assets/img/menu/frap_oreo.png'],
                    ['name' => 'Kit Kat Frappuccino',    'description' => 'Crispy wafers meet cold brew.',               'price' => 35.00, 'sale_price' => null, 'image' => 'assets/img/menu/frap_kitkat.png'],
                ],
            ],

            /** 6. Iced & Bubble Teas **/
            [
                'name'  => 'Iced & Bubble Teas',
                'items' => [
                    ['name' => 'Iced Tea – Peach',        'description' => 'Real peach purée & chilled black tea.',       'price' => 30.00, 'sale_price' => null, 'image' => 'assets/img/menu/icedtea_peach.png'],
                    ['name' => 'Iced Tea – Mango',        'description' => 'Tropical & thirst-quenching.',               'price' => 30.00, 'sale_price' => null, 'image' => 'assets/img/menu/icedtea_mango.png'],
                    ['name' => 'Bubble Tea – Strawberry', 'description' => 'Chewy boba, sweet strawberry brew.',         'price' => 45.00, 'sale_price' => null, 'image' => 'assets/img/menu/bubble_strawberry.png'],
                    ['name' => 'Bubble Tea – Passion',    'description' => 'Passion-fruit flavour pearls.',              'price' => 45.00, 'sale_price' => null, 'image' => 'assets/img/menu/bubble_passion.png'],
                ],
            ],

            /** 7. Mojitos & Mocktails **/
            [
                'name'  => 'Mojitos & Mocktails',
                'items' => [
                    ['name' => 'Mojito Soda (Classic)', 'description' => 'Lime, mint & fizz.',          'price' => 28.00, 'sale_price' => null, 'image' => 'assets/img/menu/mojito_soda.png'],
                    ['name' => 'Mojito Energy',          'description' => 'Minty boost with energy drink.', 'price' => 35.00, 'sale_price' => null, 'image' => 'assets/img/menu/mojito_energy.png'],
                    ['name' => 'Mojito Red Bull',        'description' => 'Ultimate pick-me-up.',        'price' => 45.00, 'sale_price' => null, 'image' => 'assets/img/menu/mojito_redbull.png'],
                ],
            ],
        ];

        /* ───────── Render view ───────── */
        return view('welcome7', compact(
            'languages',
            'restaurant',
            'menu',
            'categories',
            'default_language'
        ));
    }
}
