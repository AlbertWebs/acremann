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
}
