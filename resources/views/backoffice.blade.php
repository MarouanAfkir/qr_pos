<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Orders • Backoffice</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --brand: #0f8b4c;
            --brand-600: #0b6b3e;
            --ring: rgba(15, 139, 76, .12);
            --ink: #1f2937;
            --muted: #6b7280;
            --line: #e7efe9;
            --card: #fff;
            --soft: #f7fcf9
        }

        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            color: var(--ink);
            background: var(--soft)
        }

        .bo-wrap {
            padding: 16px
        }

        .bo-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, .06)
        }

        .bo-head {
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .bo-title {
            font-weight: 800;
            margin: 0
        }

        .bo-body {
            padding: 14px 16px
        }

        .stat {
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            padding: 10px 12px
        }

        .stat h4 {
            margin: 0;
            font-weight: 800
        }

        .btn-main {
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 800;
            padding: .5rem .8rem
        }

        .btn-main:hover {
            background: var(--brand-600)
        }

        .pill {
            border-radius: 999px;
            border: 1px solid var(--line);
            padding: .2rem .5rem;
            font-weight: 700;
            font-size: .8rem;
            background: #fff
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #d8efe0
        }

        .table> :not(caption)>*>* {
            padding: .65rem .75rem;
            vertical-align: middle
        }

        .badge-soft {
            background: #eefaf3;
            color: #075e3a;
            border: 1px solid #cfeedd;
            font-weight: 800
        }

        .row-actions .btn {
            border: 1px solid #e6f3ea;
            background: #fff;
            border-radius: 10px;
        }

        .search-row {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap
        }

        .search-row>* {
            flex: 1 1 160px
        }
    </style>
</head>

<body>
    <div id="app" class="bo-wrap">
        <orders-admin :currency="' {{ config('app.currency', ' DH') }} '" :orders-endpoint="'/admin/orders'"
            :me-endpoint="'/api/admin/me'" />
    </div>

    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>
