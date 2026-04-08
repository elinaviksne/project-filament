<?php

namespace App\Providers\Filament;

use App\Http\Middleware\SetLocale;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName(fn (): string => __('app.brand_name'))
            ->brandLogo(asset('images/pricematch-logo.png'))
            ->brandLogoHeight('2.25rem')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->navigationGroups([
                NavigationGroup::make(fn (): string => __('app.nav.shop_management')),
                NavigationGroup::make(fn (): string => __('app.nav.analytics')),
                NavigationGroup::make(fn (): string => __('app.nav.user_management')),
            ])
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn (): \Illuminate\Contracts\View\View => view('filament.hooks.language-switcher'),
            )
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_AFTER,
                fn (): \Illuminate\Contracts\View\View => view('filament.hooks.topbar-language-switcher'),
            )
            ->userMenuItems([
                Action::make('switchContext')
                    ->label(fn (): string => request()->routeIs('filament.admin.*')
                        ? __('app.home.back_to_home')
                        : __('app.home.go_to_admin'))
                    ->icon(fn (): string => request()->routeIs('filament.admin.*')
                        ? 'heroicon-o-home'
                        : 'heroicon-o-squares-2x2')
                    ->url(fn (): string => request()->routeIs('filament.admin.*')
                        ? route('home')
                        : filament()->getUrl())
                    ->visible(fn (): bool => request()->routeIs('filament.admin.*')
                        || (bool) filament()->auth()->user()?->is_admin)
                    ->sort(-1),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                SetLocale::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
