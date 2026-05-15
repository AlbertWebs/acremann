<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Branding')
                    ->description('Upload both logo variants — theme for light backgrounds, white for dark sections and the CMS sidebar.')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Theme logo')
                            ->image()
                            ->directory('branding')
                            ->disk('public')
                            ->maxSize(2048)
                            ->helperText('Full-colour / forest mark for light backgrounds (header, footer).'),
                        FileUpload::make('logo_white_path')
                            ->label('White logo')
                            ->image()
                            ->directory('branding')
                            ->disk('public')
                            ->maxSize(2048)
                            ->helperText('White or light mark for dark backgrounds (forest sections, admin sidebar).'),
                        FileUpload::make('favicon_path')
                            ->label('Favicon / site icon')
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
                            ->helperText('Square icon, 32×32 or 64×64 px recommended.'),
                    ])
                    ->columnSpanFull(),
                TextInput::make('company_name')->required()->default('Acremann Properties'),
                TextInput::make('tagline'),
                FormComponents::richEditor('mission'),
                FormComponents::richEditor('vision'),
                FormComponents::richEditor('about_summary'),
                TextInput::make('whatsapp'),
                TextInput::make('phone')->tel(),
                TextInput::make('email')->label('Email address')->email(),
                TextInput::make('address'),
                TextInput::make('youtube_url')->url(),
                TextInput::make('podcast_url')->url(),
                TextInput::make('facebook_url')->url(),
                TextInput::make('instagram_url')->url(),
                TextInput::make('linkedin_url')->url(),
                FormComponents::richEditor('csr_statement'),
                FormComponents::richEditor('referral_program'),
                FormComponents::richEditor('sustainability_intro'),
                FormComponents::richEditor('investment_intro'),
                TextInput::make('ga_measurement_id'),
                TextInput::make('gtm_container_id'),
                TextInput::make('meta_pixel_id'),
            ]);
    }
}
