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

    public function test_total_sums_status_counts(): void
    {
        $this->assertSame(73, PlotInventoryGenerator::total(38, 35));
        $this->assertSame(75, PlotInventoryGenerator::total(38, 35, 2));
    }
}
