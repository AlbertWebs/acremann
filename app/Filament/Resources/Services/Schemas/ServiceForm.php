<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service overview')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Public URL: /services/{slug}'),
                        TextInput::make('icon')
                            ->label('Icon key')
                            ->placeholder('land, advisory, legal, global')
                            ->maxLength(50),
                        Textarea::make('summary')
                            ->label('Card summary')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Shown on the services listing and search snippets.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Images')
                    ->description('Header image appears behind the title on the service page with a green overlay. Featured image is used on the services listing card.')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->schema([
                        FileUpload::make('header_image')
                            ->label('Header background image')
                            ->image()
                            ->directory('services/headers')
                            ->disk('public')
                            ->maxSize(5120)
                            ->helperText('Recommended: wide landscape photo (e.g. 1920×800). Darker overlay on the left keeps text readable.')
                            ->columnSpanFull(),
                        FileUpload::make('featured_image')
                            ->label('Featured image (listing card)')
                            ->image()
                            ->directory('services/featured')
                            ->disk('public')
                            ->maxSize(4096)
                            ->helperText('Shown on /services grid. Falls back to the icon if empty.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Service page content')
                    ->description('Full article for the dedicated service page.')
                    ->schema([
                        FormComponents::richEditor('body')
                            ->label('Main content')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Audience callouts')
                    ->description('Short blocks for Kenya-based and diaspora buyers on the service page.')
                    ->icon(Heroicon::OutlinedUserGroup)
                    ->schema([
                        Textarea::make('local_summary')
                            ->label('For buyers in Kenya')
                            ->rows(4)
                            ->helperText('Local buyers, investors on the ground, and first-time plot purchasers.')
                            ->columnSpanFull(),
                        Textarea::make('diaspora_summary')
                            ->label('For diaspora buyers')
                            ->rows(4)
                            ->helperText('Buyers abroad — remote purchase, milestones, and documented updates.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('SEO')
                    ->icon(Heroicon::OutlinedMagnifyingGlass)
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta title')
                            ->maxLength(255)
                            ->placeholder('Land sales Kenya | Clean title plots Nairobi & Kiambu')
                            ->columnSpanFull(),
                        Textarea::make('meta_description')
                            ->label('Meta description')
                            ->rows(3)
                            ->maxLength(320)
                            ->helperText('Target Kenya + diaspora keywords naturally (max ~160 chars recommended for Google).')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Publishing')
                    ->schema([
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
