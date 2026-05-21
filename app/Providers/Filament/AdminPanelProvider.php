<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Filament\Resources\AssistantMenuItems\AssistantMenuItemResource;
use App\Filament\Resources\AssistantSessions\AssistantSessionResource;
use App\Filament\Resources\SiteSettings\Pages\ManageAssistantSettings;
use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Resources\Properties\PropertyResource;
use App\Filament\Resources\Invest\Pages\ManageInvestPage;
use App\Filament\Resources\SiteSettings\Pages\ManageHomepageHero;
use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Enums\UserMenuPosition;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
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
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): HtmlString => new HtmlString(
                    '<link rel="preconnect" href="https://fonts.bunny.net">'
                    .'<link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600|dm-sans:400,500,600,700" rel="stylesheet">'
                ),
            )
            ->login(Login::class)
            ->profile()
            ->colors([
                'primary' => Color::hex('#2D4A3E'),   /* Forest — main actions, edit */
                'success' => Color::hex('#2D6A4F'),   /* Confirmed / available */
                'warning' => Color::hex('#B8956B'),   /* Gold — reserved / caution */
                'danger' => Color::hex('#DC2626'),    /* Delete / sold / errors */
                'info' => Color::hex('#4A6B8A'),      /* View / info links */
                'gray' => Color::hex('#6B6B66'),      /* Muted / draft */
                'gold' => Color::hex('#B8956B'),      /* Accent highlights */
            ])
            ->brandName('Acremann CMS')
            ->brandLogo(fn (): ?string => SiteSetting::current()->themeLogoUrl())
            ->darkModeBrandLogo(fn (): ?string => SiteSetting::current()->whiteLogoUrl())
            ->brandLogoHeight('2rem')
            ->favicon(fn (): ?string => SiteSetting::current()->faviconUrl())
            ->topbar()
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('17rem')
            ->collapsedSidebarWidth('4.75rem')
            ->collapsibleNavigationGroups(false)
            ->userMenu(position: UserMenuPosition::Topbar)
            ->renderHook(
                PanelsRenderHook::SIDEBAR_LOGO_AFTER,
                fn (): string => Blade::render('filament.hooks.sidebar-hero'),
            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_FOOTER,
                fn (): string => Blade::render('filament.hooks.sidebar-footer'),
            )
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn (): string => Blade::render('filament.hooks.topbar-visit-website'),
            )
            ->userMenuItems([
                Action::make('assistant')
                    ->label('Assistant conversations')
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                    ->url(fn (): string => AssistantSessionResource::getUrl('index'))
                    ->sort(-17),
                Action::make('assistantContent')
                    ->label('Assistant content')
                    ->icon(Heroicon::OutlinedAdjustmentsHorizontal)
                    ->url(fn (): string => ManageAssistantSettings::getUrl())
                    ->sort(-16),
                Action::make('assistantMenu')
                    ->label('Assistant menu')
                    ->icon(Heroicon::OutlinedBars3BottomLeft)
                    ->url(fn (): string => AssistantMenuItemResource::getUrl('index'))
                    ->sort(-15),
                Action::make('leads')
                    ->label('Leads')
                    ->icon(Heroicon::OutlinedUserGroup)
                    ->url(fn (): string => LeadResource::getUrl('index'))
                    ->sort(-14),
                Action::make('investPage')
                    ->label('Invest page')
                    ->icon(Heroicon::OutlinedChartBarSquare)
                    ->url(fn (): string => ManageInvestPage::getUrl())
                    ->sort(-14),
                Action::make('homepageHero')
                    ->label('Homepage Hero')
                    ->icon(Heroicon::OutlinedHomeModern)
                    ->url(fn (): string => ManageHomepageHero::getUrl())
                    ->sort(-13),
                Action::make('properties')
                    ->label('Properties')
                    ->icon(Heroicon::OutlinedBuildingOffice2)
                    ->url(fn (): string => PropertyResource::getUrl('index'))
                    ->sort(-12),
                Action::make('siteSettings')
                    ->label('Site settings')
                    ->icon(Heroicon::OutlinedCog6Tooth)
                    ->url(fn (): string => SiteSettingResource::getUrl('index'))
                    ->sort(-12),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
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
            ]);
    }
}
