<?php

namespace Tests\Unit;

use App\Models\Plot;
use App\Models\Property;
use App\Support\PlotInventoryGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlotInventoryGeneratorTest extends TestCase
{
    use RefreshDatabase;
    public function test_generates_plots_with_status_counts_and_numbering(): void
    {
        $plots = PlotInventoryGenerator::generate(
            available: 3,
            sold: 2,
            reserved: 1,
            prefix: 'A-',
            startNumber: 1,
            padLength: 2,
            defaultSize: '50 x 100 ft',
            defaultPrice: '850000',
        );

        $this->assertCount(6, $plots);
        $this->assertSame([
            ['plot_number' => 'A-01', 'status' => 'sold', 'size' => '50 x 100 ft', 'price' => '850000'],
            ['plot_number' => 'A-02', 'status' => 'sold', 'size' => '50 x 100 ft', 'price' => '850000'],
            ['plot_number' => 'A-03', 'status' => 'reserved', 'size' => '50 x 100 ft', 'price' => '850000'],
            ['plot_number' => 'A-04', 'status' => 'available', 'size' => '50 x 100 ft', 'price' => '850000'],
            ['plot_number' => 'A-05', 'status' => 'available', 'size' => '50 x 100 ft', 'price' => '850000'],
            ['plot_number' => 'A-06', 'status' => 'available', 'size' => '50 x 100 ft', 'price' => '850000'],
        ], $plots);
    }

    public function test_resolve_counts_from_total_sold_and_reserved(): void
    {
        $this->assertSame([
            'total' => 38,
            'sold' => 35,
            'reserved' => 0,
            'available' => 3,
        ], PlotInventoryGenerator::resolveCounts(38, 35));

        $this->assertSame([
            'total' => 38,
            'sold' => 35,
            'reserved' => 2,
            'available' => 1,
        ], PlotInventoryGenerator::resolveCounts(38, 35, 2));

        $this->assertNull(PlotInventoryGenerator::resolveCounts(0, 0));
        $this->assertNull(PlotInventoryGenerator::resolveCounts(38, 30, 10));
    }

    public function test_generates_thirty_eight_plots_for_thirty_five_sold_out_of_thirty_eight(): void
    {
        $counts = PlotInventoryGenerator::resolveCounts(38, 35);
        $this->assertNotNull($counts);

        $plots = PlotInventoryGenerator::generate(
            available: $counts['available'],
            sold: $counts['sold'],
            reserved: $counts['reserved'],
            prefix: 'A-',
            startNumber: 1,
            padLength: PlotInventoryGenerator::padLengthForTotal($counts['total'], 1, 'A-'),
        );

        $this->assertCount(38, $plots);
        $this->assertSame('A-01', $plots[0]['plot_number']);
        $this->assertSame('sold', $plots[34]['status']);
        $this->assertSame('A-35', $plots[34]['plot_number']);
        $this->assertSame('A-38', $plots[37]['plot_number']);
        $this->assertSame('available', $plots[37]['status']);
    }

    public function test_replace_for_property_deletes_excess_plots(): void
    {
        $property = Property::create([
            'title' => 'Test Estate',
            'slug' => 'test-estate',
            'status' => 'available',
            'project_status' => 'selling',
            'category' => 'residential',
            'title_type' => 'freehold',
            'listing_type' => 'sale',
            'location' => 'Test',
            'is_featured' => false,
            'is_published' => true,
            'sort_order' => 0,
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

        $counts = PlotInventoryGenerator::replaceForProperty(
            property: $property,
            total: 38,
            sold: 35,
            prefix: 'A',
            defaultSize: '50 x 100 ft',
            defaultPrice: '400000',
        );

        $this->assertNotNull($counts);
        $this->assertSame(38, $property->plots()->count());
        $this->assertSame(35, $property->plots()->where('status', 'sold')->count());
        $this->assertSame(3, $property->plots()->where('status', 'available')->count());
        $this->assertSame('A38', $property->plots()->orderByDesc('id')->value('plot_number'));
    }

    public function test_replace_for_property_can_mark_one_plot_as_only_available(): void
    {
        $property = Property::create([
            'title' => 'Sunset Estate',
            'slug' => 'sunset-estate',
            'status' => 'available',
            'project_status' => 'selling',
            'category' => 'residential',
            'title_type' => 'freehold',
            'listing_type' => 'sale',
            'location' => 'Nachu',
            'plot_size' => '50 x 100 ft',
            'price_from' => 400000,
            'is_featured' => false,
            'is_published' => true,
            'sort_order' => 0,
        ]);

        $counts = PlotInventoryGenerator::replaceForProperty(
            property: $property,
            total: 38,
            sold: 0,
            prefix: 'A',
            defaultSize: '50 x 100 ft',
            defaultPrice: '400000',
            onlyAvailablePlot: 'A04',
        );

        $this->assertNotNull($counts);
        $this->assertSame(38, $property->plots()->count());
        $this->assertSame(37, $property->plots()->where('status', 'sold')->count());
        $this->assertSame(1, $property->plots()->where('status', 'available')->count());
        $this->assertSame('available', $property->plots()->where('plot_number', 'A04')->value('status'));
    }
}
