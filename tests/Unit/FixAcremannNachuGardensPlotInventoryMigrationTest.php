<?php

namespace Tests\Unit;

use App\Models\Plot;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FixAcremannNachuGardensPlotInventoryMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_replaces_seventy_three_plots_with_thirty_eight_and_a04_available(): void
    {
        $property = Property::create([
            'title' => 'Nachu Mikuyuini Sunset Estate Phase 1',
            'slug' => 'acremann-nachu-gardens',
            'status' => 'available',
            'project_status' => 'selling',
            'category' => 'residential',
            'title_type' => 'freehold',
            'listing_type' => 'sale',
            'location' => 'Nachu',
            'plot_size' => '50 x 100 ft',
            'price_from' => 400000,
            'is_featured' => true,
            'is_published' => true,
            'sort_order' => 1,
        ]);

        foreach (range(1, 73) as $number) {
            Plot::create([
                'property_id' => $property->id,
                'plot_number' => 'A'.str_pad((string) $number, 2, '0', STR_PAD_LEFT),
                'status' => $number <= 38 ? 'sold' : 'available',
                'size' => '50 x 100 ft',
                'price' => 400000,
            ]);
        }

        /** @var \Illuminate\Database\Migrations\Migration $migration */
        $migration = include database_path('migrations/2026_06_12_170500_fix_acremann_nachu_gardens_plot_inventory.php');
        $migration->up();

        $property->refresh();

        $this->assertSame(38, $property->plots()->count());
        $this->assertSame(37, $property->plots()->where('status', 'sold')->count());
        $this->assertSame(1, $property->plots()->where('status', 'available')->count());
        $this->assertSame('available', $property->plots()->where('plot_number', 'A04')->value('status'));
        $this->assertNull($property->plots()->where('plot_number', 'A73')->first());
    }
}
