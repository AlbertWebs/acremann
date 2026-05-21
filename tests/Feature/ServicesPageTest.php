<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicesPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_index_links_to_detail_pages(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        $response = $this->get('/services');

        $response->assertOk();
        $response->assertSee('Explore our services', false);
        $response->assertSee(route('services.show', 'land-sales'), false);
        $response->assertSee(route('services.show', 'diaspora-support'), false);
        $this->assertCount(4, \App\Models\Service::published()->get());
    }

    public function test_service_show_page_is_seo_friendly(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        $response = $this->get('/services/diaspora-support');

        $response->assertOk();
        $response->assertSee('Diaspora Support', false);
        $response->assertSee('Buyers in Kenya', false);
        $response->assertSee('Diaspora investors', false);
        $response->assertSee('Buy land in Kenya from abroad', false);
    }

    public function test_unpublished_service_returns_not_found(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        Service::query()->where('slug', 'land-sales')->update(['is_published' => false]);

        $this->get('/services/land-sales')->assertNotFound();
    }
}
