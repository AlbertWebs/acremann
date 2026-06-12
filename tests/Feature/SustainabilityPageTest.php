<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SustainabilityPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_sustainability_page_renders_without_html_tags(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        $response = $this->get('/sustainability');

        $response->assertStatus(200);
        $response->assertSee('page-hero', false);
        $response->assertSee('Land investment for future generations', false);
        $response->assertSee('Responsible land use, green open spaces', false);
        $response->assertSee('community tree planting', false);
        $response->assertDontSee('sustain-hero-image', false);
        $response->assertDontSee('APL105.jpg', false);
        $response->assertDontSee('<p>Responsible land use', false);
        $response->assertDontSee('<p>We invest in community', false);
    }
}
