<?php

namespace App\Filament\Resources\SiteVisitBookings\Pages;

use App\Filament\Resources\SiteVisitBookings\SiteVisitBookingResource;
use Filament\Resources\Pages\ListRecords;

class ListSiteVisitBookings extends ListRecords
{
    protected static string $resource = SiteVisitBookingResource::class;

    public function getSubheading(): ?string
    {
        return 'Requests from /book-visit. Open a booking to confirm, add notes, and update status.';
    }
}
