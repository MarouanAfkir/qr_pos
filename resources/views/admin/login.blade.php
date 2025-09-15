<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin login</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
</head>

<body style="display:grid;place-items:center;min-height:100vh;background:#f7f8fa">
    <form method="POST" 
        style="background:#fff;padding:1rem;border:1px solid #e6eaee;border-radius:12px;min-width:320px">
        @csrf
        <h3 style="margin:0 0 .5rem 0">Back-office</h3>
        @error('email')
            <div style="color:#b91c1c;margin-bottom:.5rem">{{ $message }}</div>
        @enderror
        <div class="mb-2">
            <label>Email</label>
            <input class="form-control" name="email" type="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-2">
            <label>Password</label>
            <input class="form-control" name="password" type="password" required>
        </div>
        <div class="mb-2">
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
        <button class="btn btn-primary w-100" type="submit">Sign in</button>
    </form>
</body>

</html>
