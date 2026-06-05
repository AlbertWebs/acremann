<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_renders_without_html_tags(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        $response = $this->get('/about');

        $response->assertOk();
        $response->assertSee('Legacy-minded real estate advisory', false);
        $response->assertSee('Mission &amp; vision', false);
        $response->assertSee('legally-grounded', false);
        $response->assertSee('most trusted advisory-led', false);
        $response->assertDontSee('<p>To deliver legally-grounded', false);
        $response->assertDontSee('<p>Acremann Properties is', false);
    }

    public function test_about_page_shows_profile_links_for_advisory_specialists(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        $specialist = \App\Models\TeamMember::query()
            ->where('is_leadership', false)
            ->where('is_published', true)
            ->firstOrFail();

        $response = $this->get('/about');

        $response->assertOk();
        $response->assertSee(route('leadership.show', $specialist), false);
        $response->assertSee('View profile →', false);
    }

    public function test_about_page_shows_brand_video_play_button(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        config(['acremann.brand_video_url' => 'https://vimeo.com/1197477405']);

        $response = $this->get('/about');

        $response->assertOk();
        $response->assertSee('about-hero-video', false);
        $response->assertSee('Play Acremann Properties video', false);
        $response->assertSee('Welcome: Acremann Properties', false);
        $response->assertDontSee('player.vimeo.com/video/1197477405', false);
    }
}
