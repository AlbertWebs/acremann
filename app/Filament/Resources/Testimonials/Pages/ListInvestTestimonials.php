<?php

namespace App\Filament\Resources\Testimonials\Pages;

use App\Filament\Resources\Testimonials\TestimonialResource;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ListInvestTestimonials extends ListRecords
{
    protected static string $resource = TestimonialResource::class;

    protected static ?string $navigationLabel = 'Client testimonials';

    protected static ?string $title = 'Invest testimonials';

    protected static ?string $slug = 'for-invest';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftEllipsis;

    protected static string|UnitEnum|null $navigationGroup = 'Invest';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldRegisterNavigation = true;

    public function getSubheading(): ?string
    {
        return 'Featured, published testimonials shown on /invest. Toggle “Featured” and “Published” when editing each record.';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return Testimonial::query()->where('is_featured', true);
    }
}
