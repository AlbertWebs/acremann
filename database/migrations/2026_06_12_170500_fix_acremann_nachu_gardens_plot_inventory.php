<?php

use App\Models\Property;
use App\Support\PlotInventoryGenerator;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $property = Property::query()
            ->where('slug', 'acremann-nachu-gardens')
            ->first();

        if (! $property) {
            return;
        }

        if ($property->plots()->count() <= 38) {
            return;
        }

        PlotInventoryGenerator::replaceForProperty(
            property: $property,
            total: 38,
            sold: 0,
            prefix: 'A',
            startNumber: 1,
            defaultSize: $property->plot_size ?: '50 x 100 ft',
            defaultPrice: $property->price_from ? (string) $property->price_from : '400000',
            onlyAvailablePlot: 'A04',
        );
    }

    public function down(): void
    {
        // One-off data correction; not reversible.
    }
};
