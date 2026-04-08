<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('app.auth.login_title') }}</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2a37; }
        .wrap { min-height: 100vh; display: grid; place-items: center; padding: 1rem; }
        .card { width: 100%; max-width: 420px; background: #fff; border: 1px solid #dce3ec; border-radius: 12px; padding: 1.25rem; }
        .title { margin: 0 0 1rem; color: #0f3f66; font-size: 1.4rem; }
        label { display: block; font-size: 0.9rem; margin-bottom: 0.35rem; font-weight: 600; }
        input { width: 100%; padding: 0.65rem 0.7rem; border: 1px solid #ccd5df; border-radius: 8px; margin-bottom: 0.9rem; }
        .row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.95rem; }
        .btn { width: 100%; border: 0; background: #0f3f66; color: #fff; padding: 0.7rem; border-radius: 8px; font-weight: 700; cursor: pointer; }
        .muted { margin-top: 0.9rem; font-size: 0.9rem; color: #6b7280; text-align: center; }
        .error { color: #b42318; font-size: 0.85rem; margin: -0.4rem 0 0.55rem; }
        a { color: #0f3f66; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
<div class="wrap">
    <form class="card" method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <h1 class="title">{{ __('app.auth.login_title') }}</h1>

        <label for="email">{{ __('app.auth.email') }}</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @error('email')<p class="error">{{ $message }}</p>@enderror

        <label for="password">{{ __('app.auth.password') }}</label>
        <input id="password" type="password" name="password" required>
        @error('password')<p class="error">{{ $message }}</p>@enderror

        <div class="row">
            <label style="margin:0; font-weight:500;">
                <input type="checkbox" name="remember" value="1" style="width:auto; margin:0 0.35rem 0 0;">
                {{ __('app.auth.remember') }}
            </label>
            <a href="{{ route('home') }}">{{ __('app.auth.back_home') }}</a>
        </div>

        <button class="btn" type="submit">{{ __('app.auth.login_button') }}</button>
        <p class="muted">{{ __('app.auth.no_account') }} <a href="{{ route('register') }}">{{ __('app.auth.register_button') }}</a></p>
    </form>
</div>
</body>
</html>
