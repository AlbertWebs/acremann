<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
