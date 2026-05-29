<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Filament\Schemas\HomepageHeroForm;
use App\Models\SiteSetting;
use App\Support\PublicStorage;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageHomepageHero extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $navigationLabel = 'Homepage Hero';

    protected static ?string $title = 'Homepage Hero';

    protected static ?string $slug = 'homepage-hero';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static ?int $navigationSort = 5;

    protected static bool $shouldRegisterNavigation = true;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(SiteSetting::current()->getKey());
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (! empty($data['hero_image_path'])) {
            $data['hero_image_path'] = PublicStorage::normalizePath($data['hero_image_path']);
        }

        $data['hero_images'] = PublicStorage::normalizePaths($data['hero_images'] ?? null);

        if ($data['hero_images'] === [] && ! empty($data['hero_image_path'])) {
            $data['hero_images'] = [$data['hero_image_path']];
        }

        if (($data['hero_media_mode'] ?? null) === 'image') {
            $data['hero_media_mode'] = 'gallery';
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $images = $data['hero_images'] ?? [];

        if (is_array($images)) {
            $images = PublicStorage::normalizePaths($images);
            $data['hero_images'] = $images;
            $data['hero_image_path'] = $images[0] ?? null;
        }

        if (($data['hero_media_mode'] ?? null) === 'image') {
            $data['hero_media_mode'] = 'gallery';
        }

        return $data;
    }

    public function form(Schema $schema): Schema
    {
        return HomepageHeroForm::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('heroVideo')
                ->label('Hero video')
                ->icon(Heroicon::OutlinedVideoCamera)
                ->url(ManageHomepageHeroVideo::getUrl(['record' => SiteSetting::current()])),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Homepage hero updated';
    }
}
