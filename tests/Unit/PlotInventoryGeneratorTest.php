<?php

namespace Tests\Unit;

use App\Support\PlotInventoryGenerator;
use PHPUnit\Framework\TestCase;

class PlotInventoryGeneratorTest extends TestCase
{
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
}
