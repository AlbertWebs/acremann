<?php

namespace Tests\Feature;

use Database\Seeders\AcremannSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FullWidthHomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_width_home_page_loads(): void
    {
        $this->seed(AcremannSeeder::class);

        $response = $this->get('/full-width');

        $response->assertOk();
        $response->assertSee('Featured properties', false);
        $response->assertSee('Insights', false);
    }

    public function test_full_width_home_page_shows_autoplaying_hero_video(): void
    {
        $this->seed(AcremannSeeder::class);

        config(['acremann.brand_video_url' => 'https://vimeo.com/1197477405']);

        $response = $this->get('/full-width');

        $response->assertOk();
        $response->assertSee('home-hero-full-width', false);
        $response->assertSee('player.vimeo.com/video/1197477405', false);
        $response->assertSee('background=1', false);
        $response->assertDontSee('home-hero-play-btn', false);
    }
}
