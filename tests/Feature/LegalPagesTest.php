<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_privacy_and_terms_pages_load(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        $this->get('/privacy')
            ->assertOk()
            ->assertSee('Privacy Notice', false);

        $this->get('/terms')
            ->assertOk()
            ->assertSee('Terms and Conditions', false);
    }

    public function test_homepage_footer_shows_legal_links_not_contact(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Terms and conditions', false);
        $response->assertSee('Privacy policy', false);
        $response->assertDontSee('site-footer-legal-link">Contact', false);
    }
}
