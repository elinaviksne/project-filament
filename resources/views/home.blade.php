<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}"
    class="fi"
>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PriceMatch</title>
    @filamentStyles
    {{ filament()->getTheme()->getHtml() }}
    {{ filament()->getFontHtml() }}
    <script>
        const loadDarkMode = () => {
            const theme = localStorage.getItem('theme') ?? @js(filament()->getDefaultThemeMode()->value);
            const shouldUseDark =
                theme === 'dark' ||
                (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

            document.documentElement.classList.toggle('dark', shouldUseDark);
        };

        const syncThemeStore = () => {
            if (! window.Alpine) return;
            Alpine.store('theme', localStorage.getItem('theme') ?? @js(filament()->getDefaultThemeMode()->value));
        };

        loadDarkMode();
        document.addEventListener('alpine:init', syncThemeStore);

        window.addEventListener('theme-changed', () => {
            loadDarkMode();
            syncThemeStore();
        });
    </script>
    <style>
        [x-cloak=''],
        [x-cloak='x-cloak'],
        [x-cloak='1'] {
            display: none !important;
        }
    </style>
    <style>
        :root {
            --pm-blue: #0f3f66;
            --pm-orange: #e99852;
            --pm-bg: #f8fbff;
            --pm-border: #17486f;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #1f2a37;
            background: #fff;
        }

        html.dark body {
            color: #e5e7eb;
            background: #0b1220;
        }

        .home-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid #d9d9d9;
            gap: 1rem;
        }

        html.dark .home-header {
            border-bottom-color: #1f2937;
            background: #0f172a;
        }

        .home-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .home-logo {
            height: 34px;
            width: auto;
        }

        .home-nav {
            display: flex;
            gap: 1rem;
            font-size: 0.95rem;
            color: #173f5f;
        }

        html.dark .home-nav {
            color: #cbd5e1;
        }

        .home-nav a {
            color: inherit;
            text-decoration: none;
            font-weight: 600;
        }

        .home-right {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .home-profile-btn {
            border: 1px solid #d5deea;
            background: #fff;
            color: #334155;
            border-radius: 0.45rem;
            padding: 0.45rem 0.8rem;
            font-size: 0.86rem;
            font-weight: 700;
            cursor: pointer;
        }

        html.dark .home-profile-btn {
            border-color: #334155;
            background: #0b1220;
            color: #e5e7eb;
        }

        .home-locale a {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.85rem;
            margin: 0 0.2rem;
        }

        .home-locale a.active {
            color: var(--pm-blue);
            font-weight: 700;
        }

        html.dark .home-locale a {
            color: #94a3b8;
        }

        html.dark .home-locale a.active {
            color: #f8fafc;
        }

        .home-btn {
            border: 1px solid var(--pm-blue);
            background: var(--pm-blue);
            color: #fff;
            border-radius: 0.45rem;
            padding: 0.45rem 0.8rem;
            font-size: 0.86rem;
            font-weight: 700;
            text-decoration: none;
        }

        .home-btn.home-btn-ghost {
            background: #fff;
            color: var(--pm-blue);
        }

        .home-content {
            padding: 1rem 1.5rem 2rem;
        }

        .home-section-title {
            background: var(--pm-orange);
            color: #2d2d2d;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            border-radius: 0.25rem;
            margin: 0.75rem 0 1rem;
            padding: 0.6rem 0.5rem;
        }

        html.dark .home-section-title {
            color: #111827;
        }

        .home-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(180px, 1fr));
            gap: 1rem;
        }

        .home-card {
            border: 4px solid var(--pm-border);
            border-radius: 1rem;
            background: var(--pm-bg);
            text-align: center;
            padding: 0.7rem 0.6rem 0.8rem;
        }

        html.dark .home-card {
            border-color: #334155;
            background: #0f172a;
        }

        .home-card-visual {
            width: 100%;
            height: 125px;
            display: grid;
            place-items: center;
            font-size: 3rem;
        }

        .home-card-name {
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0.25rem 0;
            text-transform: uppercase;
        }

        .home-card-price {
            color: #d85b67;
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0;
        }

        html.dark .home-card-price {
            color: #fb7185;
        }

        .home-empty {
            text-align: center;
            color: #6b7280;
            margin: 1.5rem 0;
        }

        html.dark .home-empty {
            color: #94a3b8;
        }

        @media (max-width: 1000px) {
            .home-grid { grid-template-columns: repeat(2, minmax(160px, 1fr)); }
        }

        @media (max-width: 640px) {
            .home-header { flex-direction: column; align-items: flex-start; }
            .home-left { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
            .home-grid { grid-template-columns: 1fr; }
            .home-section-title { font-size: 1.2rem; }
        }
    </style>
</head>
<body class="fi-body fi-panel-admin">
    <header class="home-header">
        <div class="home-left">
            <img src="{{ asset('images/pricematch-logo.png') }}" alt="PriceMatch" class="home-logo">
            <nav class="home-nav">
                <a href="#">{{ __('app.home.nav_home') }}</a>
                <a href="#">{{ __('app.home.nav_catalog') }}</a>
                <a href="#">{{ __('app.home.nav_shops') }}</a>
                <a href="#">{{ __('app.home.nav_about') }}</a>
            </nav>
        </div>
        <div class="home-right">
            <div class="home-locale">
                <a href="{{ route('locale.switch', ['locale' => 'lv']) }}" class="{{ app()->getLocale() === 'lv' ? 'active' : '' }}">LV</a>
                |
                <a href="{{ route('locale.switch', ['locale' => 'en']) }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
            @auth
                <div class="fi">
                    @livewire(\Filament\Livewire\SimpleUserMenu::class)
                </div>
            @else
                <a class="home-btn home-btn-ghost" href="{{ route('login') }}">{{ __('app.home.sign_in') }}</a>
                <a class="home-btn" href="{{ route('register') }}">{{ __('app.home.sign_up') }}</a>
            @endauth
        </div>
    </header>

    <main class="home-content">
        <section>
            <h2 class="home-section-title">{{ __('app.home.popular_products') }}</h2>
            @if ($popularProducts->isEmpty())
                <p class="home-empty">{{ __('app.home.no_products') }}</p>
            @else
                <div class="home-grid">
                    @foreach ($popularProducts as $product)
                        <article class="home-card">
                            <div class="home-card-visual">PC</div>
                            <p class="home-card-name">{{ $product->name }}</p>
                            <p class="home-card-price">
                                {{ __('app.home.from_price') }}
                                {{ $product->offers_min_price ? number_format((float) $product->offers_min_price, 2) . '€' : '-' }}
                            </p>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <h2 class="home-section-title">{{ __('app.home.other_products') }}</h2>
            @if ($otherProducts->isEmpty())
                <p class="home-empty">{{ __('app.home.no_products') }}</p>
            @else
                <div class="home-grid">
                    @foreach ($otherProducts as $product)
                        <article class="home-card">
                            <div class="home-card-visual">PC</div>
                            <p class="home-card-name">{{ $product->name }}</p>
                            <p class="home-card-price">
                                {{ __('app.home.from_price') }}
                                {{ $product->offers_min_price ? number_format((float) $product->offers_min_price, 2) . '€' : '-' }}
                            </p>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
    @filamentScripts(withCore: true)
</body>
</html>
