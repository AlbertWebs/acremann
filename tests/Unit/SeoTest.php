<?php

namespace Tests\Unit;

use App\Support\Seo;
use Database\Seeders\AcremannSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;
    public function test_page_title_appends_site_name(): void
    {
        $this->assertSame(
            'About Us | Acremann Properties',
            Seo::pageTitle('About Us', 'Acremann Properties')
        );
    }

    public function test_page_title_skips_duplicate_site_name(): void
    {
        $this->assertSame(
            'Insights | Acremann Properties',
            Seo::pageTitle('Insights | Acremann Properties', 'Acremann Properties')
        );
    }

    public function test_default_title_when_empty(): void
    {
        $this->assertStringContainsString('Acremann Properties', Seo::pageTitle(null, 'Acremann Properties'));
        $this->assertStringContainsString('Kenya', Seo::pageTitle(null, 'Acremann Properties'));
    }

    public function test_description_truncates_long_text(): void
    {
        $long = str_repeat('Verified plots in Kenya. ', 20);

        $this->assertLessThanOrEqual(160, mb_strlen(Seo::description($long)));
    }

    public function test_organization_schema_includes_google_maps_geo(): void
    {
        $this->seed(AcremannSeeder::class);

        config([
            'acremann.local_business.latitude' => -1.2710368,
            'acremann.local_business.longitude' => 36.8444699,
            'acremann.local_business.google_maps_url' => 'https://maps.google.com/example',
        ]);

        $schema = Seo::organizationSchema();

        $this->assertContains('RealEstateAgent', $schema['@type']);
        $this->assertContains('LocalBusiness', $schema['@type']);
        $this->assertSame(-1.2710368, $schema['geo']['latitude']);
        $this->assertSame(36.8444699, $schema['geo']['longitude']);
        $this->assertSame('https://maps.google.com/example', $schema['hasMap']);
        $this->assertContains('https://maps.google.com/example', $schema['sameAs']);
    }

    public function test_graph_wraps_nodes_with_schema_context(): void
    {
        $graph = Seo::graph([
            ['@type' => 'WebSite', 'name' => 'Test'],
        ]);

        $this->assertSame('https://schema.org', $graph['@context']);
        $this->assertCount(1, $graph['@graph']);
    }
}
