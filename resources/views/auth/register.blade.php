<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('app.auth.register_title') }}</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2a37; }
        .wrap { min-height: 100vh; display: grid; place-items: center; padding: 1rem; }
        .card { width: 100%; max-width: 450px; background: #fff; border: 1px solid #dce3ec; border-radius: 12px; padding: 1.25rem; }
        .title { margin: 0 0 1rem; color: #0f3f66; font-size: 1.4rem; }
        label { display: block; font-size: 0.9rem; margin-bottom: 0.35rem; font-weight: 600; }
        input { width: 100%; padding: 0.65rem 0.7rem; border: 1px solid #ccd5df; border-radius: 8px; margin-bottom: 0.9rem; }
        .btn { width: 100%; border: 0; background: #0f3f66; color: #fff; padding: 0.7rem; border-radius: 8px; font-weight: 700; cursor: pointer; }
        .muted { margin-top: 0.9rem; font-size: 0.9rem; color: #6b7280; text-align: center; }
        .error { color: #b42318; font-size: 0.85rem; margin: -0.4rem 0 0.55rem; }
        a { color: #0f3f66; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
<div class="wrap">
    <form class="card" method="POST" action="{{ route('register.store') }}">
        @csrf
        <h1 class="title">{{ __('app.auth.register_title') }}</h1>

        <label for="name">{{ __('app.auth.name') }}</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required>
        @error('name')<p class="error">{{ $message }}</p>@enderror

        <label for="email">{{ __('app.auth.email') }}</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @error('email')<p class="error">{{ $message }}</p>@enderror

        <label for="password">{{ __('app.auth.password') }}</label>
        <input id="password" type="password" name="password" required>
        @error('password')<p class="error">{{ $message }}</p>@enderror

        <label for="password_confirmation">{{ __('app.auth.password_confirm') }}</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <button class="btn" type="submit">{{ __('app.auth.register_button') }}</button>
        <p class="muted">{{ __('app.auth.have_account') }} <a href="{{ route('login') }}">{{ __('app.auth.login_button') }}</a></p>
    </form>
</div>
</body>
</html>
