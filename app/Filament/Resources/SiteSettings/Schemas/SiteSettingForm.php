<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('SiteSettings')
                    ->contained(false)
                    ->persistTabInQueryString()
                    ->tabs([
                        Tab::make('Brand')
                            ->icon(Heroicon::OutlinedSparkles)
                            ->schema(static::brandTab()),
                        Tab::make('Contact')
                            ->icon(Heroicon::OutlinedPhone)
                            ->schema(static::contactTab()),
                        Tab::make('Content')
                            ->icon(Heroicon::OutlinedDocumentText)
                            ->schema(static::contentTab()),
                        Tab::make('Analytics')
                            ->icon(Heroicon::OutlinedChartBar)
                            ->schema(static::analyticsTab()),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @return array<int, mixed>
     */
    protected static function brandTab(): array
    {
        return [
            Section::make('Logos & icon')
                ->description('Theme logo for the header and admin; footer logo for the site footer; white logo for the preloader and CMS sign-in.')
                ->icon(Heroicon::OutlinedPhoto)
                ->compact()
                ->schema([
                    FileUpload::make('logo_path')
                        ->label('Theme logo')
                        ->image()
                        ->directory('branding')
                        ->disk('public')
                        ->maxSize(2048)
                        ->helperText('Header, admin sidebar, and fallback when no footer logo is set.'),
                    FileUpload::make('logo_footer_path')
                        ->label('Footer logo')
                        ->image()
                        ->directory('branding')
                        ->disk('public')
                        ->maxSize(2048)
                        ->helperText('Shown in the site footer brand card. Leave empty to use the theme logo.'),
                    FileUpload::make('logo_white_path')
                        ->label('White logo')
                        ->image()
                        ->directory('branding')
                        ->disk('public')
                        ->maxSize(2048)
                        ->helperText('For the site preloader and CMS sign-in panel. Upload cream or white artwork on a transparent PNG — not the green theme logo.'),
                    FileUpload::make('favicon_path')
                        ->label('Favicon')
                        ->image()
                        ->directory('branding')
                        ->disk('public')
                        ->maxSize(512)
                        ->acceptedFileTypes([
                            'image/png',
                            'image/x-icon',
                            'image/vnd.microsoft.icon',
                            'image/svg+xml',
                        ])
                        ->helperText('32×32 or 64×64 px.'),
                ])
                ->columns(4)
                ->columnSpanFull(),
            Section::make('Company identity')
                ->icon(Heroicon::OutlinedBuildingOffice2)
                ->compact()
                ->schema([
                    TextInput::make('company_name')
                        ->required()
                        ->default('Acremann Properties')
                        ->placeholder('Acremann Properties')
                        ->columnSpanFull(),
                    TextInput::make('tagline')
                        ->placeholder('Trusted guidance. Transparent process. Sustainable value.')
                        ->columnSpanFull(),
                ])
                ->columns(1)
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function contactTab(): array
    {
        return [
            Section::make('Reach us')
                ->description('Displayed in the footer, contact page, and assistant widget.')
                ->icon(Heroicon::OutlinedEnvelope)
                ->compact()
                ->schema([
                    TextInput::make('whatsapp')
                        ->label('WhatsApp number')
                        ->tel()
                        ->placeholder('254115874901'),
                    TextInput::make('phone')
                        ->tel()
                        ->placeholder('0115 874 901'),
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->placeholder('info@acremannproperties.com'),
                    TextInput::make('address')
                        ->placeholder('Nairobi, Kenya')
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->columnSpanFull(),
            Section::make('Social profiles')
                ->icon(Heroicon::OutlinedShare)
                ->compact()
                ->collapsed()
                ->schema([
                    TextInput::make('youtube_url')->label('YouTube')->url()->placeholder('https://'),
                    TextInput::make('podcast_url')->label('TikTok')->url()->placeholder('https://www.tiktok.com/@…'),
                    TextInput::make('facebook_url')->label('Facebook')->url()->placeholder('https://'),
                    TextInput::make('instagram_url')->label('Instagram')->url()->placeholder('https://'),
                    TextInput::make('linkedin_url')->label('LinkedIn')->url()->placeholder('https://'),
                ])
                ->columns(2)
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function contentTab(): array
    {
        return [
            Section::make('About Acremann')
                ->description('Used on the about page and key marketing sections.')
                ->icon(Heroicon::OutlinedBookOpen)
                ->compact()
                ->schema([
                    FormComponents::richEditor('mission')
                        ->label('Mission'),
                    FormComponents::richEditor('vision')
                        ->label('Vision'),
                    FormComponents::richEditor('about_summary')
                        ->label('About summary'),
                ])
                ->columnSpanFull(),
            Section::make('Programme pages')
                ->icon(Heroicon::OutlinedRectangleStack)
                ->compact()
                ->collapsed()
                ->schema([
                    FormComponents::richEditor('csr_statement')->label('CSR statement'),
                    FormComponents::richEditor('referral_program')->label('Referral programme'),
                    FormComponents::richEditor('sustainability_intro')->label('Sustainability intro'),
                ])
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function analyticsTab(): array
    {
        return [
            Section::make('Tracking & pixels')
                ->description('Optional. Leave blank to disable.')
                ->icon(Heroicon::OutlinedSignal)
                ->compact()
                ->schema([
                    TextInput::make('ga_measurement_id')
                        ->label('Google Analytics ID')
                        ->placeholder('G-XXXXXXXXXX')
                        ->helperText('GA4 measurement ID.'),
                    TextInput::make('gtm_container_id')
                        ->label('Google Tag Manager')
                        ->placeholder('GTM-XXXXXXX'),
                    TextInput::make('meta_pixel_id')
                        ->label('Meta Pixel ID')
                        ->placeholder('1234567890'),
                ])
                ->columns(1)
                ->columnSpanFull(),
        ];
    }
}
