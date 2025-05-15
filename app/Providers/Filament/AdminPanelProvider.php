<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Settings\GeneralSettings;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Support\Enums\MaxWidth;
use App\Filament\Pages\DashboardPage;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\FontProviders\GoogleFontProvider;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // $logo = asset('storage/' . app(GeneralSettings::class)->logo);
        // $name_site = app(GeneralSettings::class)->site_name_en;

        return $panel
            ->default()
            ->id('admin')
            ->profile(isSimple: false)
            ->maxContentWidth(MaxWidth::Full)
            // ->spa()
            ->path('admin')


            ->login()
            ->colors([
                'primary' => [
                    50 => '238, 242, 255',
                    100 => '224, 231, 255',
                    200 => '199, 210, 254',
                    300 => '165, 180, 252',
                    400 => '129, 140, 248',
                    500 => '99, 102, 241',
                    600 => '79, 70, 229',
                    700 => '67, 56, 202',
                    800 => '55, 48, 163',
                    900 => '49, 46, 129',
                    950 => '30, 27, 75',
                ],
            ])

            // ->brandName(function () {
            //     $locale = app()->getLocale();
            //     $property = 'site_name_' . $locale;
            //     return app(GeneralSettings::class)->$property;
            // })

               ->brandName( 'Hotelify')

            //  ->brandLogo(fn () => view('filament.admin.logo'))
            // ->brandLogo(fn() => view('filament.admin.logoDark'))
            ->darkModeBrandLogo(asset('hotel.png'))
            ->brandLogo(asset('logo_w.webp'))
            ->brandLogoHeight('3rem')


            // ->favicon(asset('storage/' . app(GeneralSettings::class)->favicon))
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotifications(true)
            ->databaseNotificationsPolling('80s')
            ->font('Inter', provider: GoogleFontProvider::class)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                DashboardPage::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class

            ])
            ->tenantMiddleware([

                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            //  ->sidebarWidth('20rem')
            ->plugins([
                \Hasnayeen\Themes\ThemesPlugin::make()
            ]);
    }
}
