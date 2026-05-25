<?php

namespace App\Filament\Resources\Certifications\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
                FormComponents::richEditor('description'),
                FileUpload::make('logo_path')
                    ->label('Logo')
                    ->image()
                    ->directory('certifications')
                    ->disk('public')
                    ->maxSize(1024)
                    ->helperText('PNG or SVG on transparent background, displayed on the home page and credentials page.'),
                TextInput::make('link')->url(),
                TextInput::make('sort_order')->required()->numeric()->default(0),
                Toggle::make('is_published')->required(),
            ]);
    }
}
