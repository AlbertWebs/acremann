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
}
