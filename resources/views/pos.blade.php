<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="googlebot" content="noindex, nofollow, noarchive, nosnippet">
    <!-- Assets -->
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Playfair+Display:wght@700;800&display=swap"
        rel="stylesheet">

    <!-- QR Scanner (optional, for client QR import) -->
    <script src="https://unpkg.com/html5-qrcode" defer></script>
</head>

<body>
    <div id="app" >
        <!-- Use kebab-case for prop names that are camelCase in the component -->
        <pos
            :articles='@json($articles ?? [])'
            :categories='@json($categories ?? [])'
            :restaurant='@json($company ?? null)'
            :languages='@json($languages ?? [])'
            :users='@json($users ?? [])'
            default-language="{{ request('lang', app()->getLocale() ?: 'en') }}"
            currency=" DH"
            placeholder="{{ asset('assets/img/gallery/placeholder.png') }}"
            logo-fallback="{{ asset('assets/img/logo/logo.svg') }}"
        />
    </div>

    <!-- Your compiled Vue 2 bundle (Laravel Mix) -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>
