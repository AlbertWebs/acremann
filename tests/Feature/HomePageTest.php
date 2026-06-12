<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Database\Seeders\AcremannSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->seed(AcremannSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Acremann Properties');
        $response->assertSee('Insights');
        $response->assertSee('How to Buy Land in Kenya Safely');
    }

    public function test_properties_page_loads(): void
    {
        $this->seed(AcremannSeeder::class);

        $response = $this->get('/properties');

        $response->assertStatus(200);
        $response->assertSee('Nachu');
    }

    public function test_classic_home_page_shows_hero_video_play_button_without_vimeo_iframe(): void
    {
        $this->seed(AcremannSeeder::class);

        config(['acremann.brand_video_url' => 'https://vimeo.com/1197477405']);

        $response = $this->get('/home-classic');

        $response->assertStatus(200);
        $response->assertSee('home-hero-play-btn', false);
        $response->assertSee('Play Acremann Properties video', false);
        $response->assertDontSee('player.vimeo.com/video/1197477405', false);
    }

    public function test_classic_home_page_shows_hero_youtube_video_when_configured(): void
    {
        $this->seed(AcremannSeeder::class);

        $settings = SiteSetting::current();
        $settings->update([
            'hero_media_mode' => 'gallery',
            'hero_images' => ['hero/sample-1.jpg', 'hero/sample-2.jpg'],
            'hero_video_enabled' => true,
            'hero_video_provider' => 'youtube',
            'hero_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response = $this->get('/home-classic');

        $response->assertStatus(200);
        $response->assertSee('youtube-nocookie.com/embed/dQw4w9WgXcQ', false);
        $response->assertSee('home-hero-video', false);
    }

    public function test_classic_home_page_loads_at_alternate_route(): void
    {
        $this->seed(AcremannSeeder::class);

        $response = $this->get('/home-classic');

        $response->assertOk();
        $response->assertSee('Insights', false);
        $response->assertDontSee('home-hero-full-width', false);
    }

    public function test_lead_form_submission(): void
    {
        $this->seed(AcremannSeeder::class);

        $response = $this->post('/leads', [
            'source' => 'contact',
            'name' => 'Test User',
            'phone' => '0712345678',
            'consent_callback' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('leads', ['name' => 'Test User', 'source' => 'contact']);
    }
}
