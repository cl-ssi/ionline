<?php

namespace App\Providers\Filament;

use App\Filament\Auth\CustomLogin;
use Awcodes\FilamentGravatar\GravatarPlugin;
use Awcodes\FilamentGravatar\GravatarProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;

class IntranetPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('intranet')
            ->sidebarCollapsibleOnDesktop()
            ->path('intranet')
            ->brandLogo(fn () => view('filament.logo'))
            ->login(CustomLogin::class)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->favicon(asset('favicon.ico'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationItems([
                NavigationItem::make('iOnline Clásico')
                    ->url(fn(): string => route('home'))
                    ->icon('heroicon-o-link'),
                NavigationItem::make('Calendario')
                    ->url(fn(): string => route('calendars'))
                    ->icon('heroicon-o-calendar'),
                NavigationItem::make('SGR')
                    ->url(fn(): string => route('requirements.inbox'))
                    ->icon('heroicon-o-rocket-launch'),
            ])
            ->defaultAvatarProvider(GravatarProvider::class)
            ->plugins([
                GravatarPlugin::make(),
                EnvironmentIndicatorPlugin::make()
                    ->visible(visible: fn (): bool|string => app()->environment('local')),
            ])
            ->databaseNotifications();
    }
}
