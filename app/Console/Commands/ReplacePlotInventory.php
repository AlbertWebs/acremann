<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Support\PlotInventoryGenerator;
use Illuminate\Console\Command;

class ReplacePlotInventory extends Command
{
    protected $signature = 'plots:replace
        {property : Property ID or slug}
        {--total= : Total plots in the development}
        {--sold= : How many are sold (remaining plots become available)}
        {--reserved=0 : How many are reserved}
        {--only-available= : Plot number that should be the only available plot (e.g. A04)}
        {--prefix=A : Plot number prefix}
        {--start=1 : Starting plot number}
        {--size= : Default plot size}
        {--price= : Default plot price}';

    protected $description = 'Replace all plots for a property (fixes bad bulk-generated inventories)';

    public function handle(): int
    {
        $property = Property::query()
            ->where('slug', $this->argument('property'))
            ->orWhere('id', $this->argument('property'))
            ->first();

        if (! $property) {
            $this->error('Property not found.');

            return self::FAILURE;
        }

        $total = (int) ($this->option('total') ?: 0);
        $sold = $this->option('sold');
        $onlyAvailable = $this->option('only-available');

        if ($total < 1) {
            $this->error('Set --total (e.g. --total=38).');

            return self::FAILURE;
        }

        if ($onlyAvailable === null && $sold === null) {
            $this->error('Set either --sold (e.g. --sold=35) or --only-available (e.g. --only-available=A04).');

            return self::FAILURE;
        }

        $existing = $property->plots()->count();
        $defaultSize = $this->option('size') ?: $property->plot_size;
        $defaultPrice = $this->option('price') ?: ($property->price_from ? (string) $property->price_from : null);

        $counts = PlotInventoryGenerator::replaceForProperty(
            property: $property,
            total: $total,
            sold: (int) ($sold ?? 0),
            reserved: (int) $this->option('reserved'),
            prefix: (string) $this->option('prefix'),
            startNumber: max(1, (int) $this->option('start')),
            defaultSize: filled($defaultSize) ? (string) $defaultSize : null,
            defaultPrice: filled($defaultPrice) ? (string) $defaultPrice : null,
            onlyAvailablePlot: filled($onlyAvailable) ? (string) $onlyAvailable : null,
        );

        if ($counts === null) {
            $this->error('Could not generate plots. Check that sold + reserved does not exceed total, and that --only-available matches a plot number.');

            return self::FAILURE;
        }

        $this->info(sprintf(
            'Replaced plot inventory for "%s" (%s): %d plots (%d sold, %d reserved, %d available). Was %d plots.',
            $property->title,
            $property->slug,
            $counts['total'],
            $counts['sold'],
            $counts['reserved'],
            $counts['available'],
            $existing,
        ));

        $property->plots()->orderBy('id')->get(['plot_number', 'status'])->each(
            fn ($plot) => $this->line('  '.$plot->plot_number.' · '.$plot->status)
        );

        return self::SUCCESS;
    }
}
