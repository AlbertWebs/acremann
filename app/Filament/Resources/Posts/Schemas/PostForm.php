<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Public URL: /insights/{slug}'),
                Textarea::make('excerpt')
                    ->label('Summary')
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText('Shown on the homepage and insights listing.')
                    ->columnSpanFull(),
                FormComponents::richEditor('body')
                    ->label('Article body')
                    ->required(),
                FileUpload::make('featured_image')
                    ->label('Cover image')
                    ->image()
                    ->directory('posts')
                    ->disk('public')
                    ->maxSize(4096),
                TextInput::make('author')
                    ->placeholder('Acremann Team'),
                DateTimePicker::make('published_at')
                    ->label('Publish date')
                    ->required()
                    ->default(now()),
                Toggle::make('is_published')
                    ->label('Published')
                    ->default(true)
                    ->required(),
                TextInput::make('meta_title')
                    ->label('SEO title')
                    ->maxLength(255),
                Textarea::make('meta_description')
                    ->label('SEO description')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }
}
