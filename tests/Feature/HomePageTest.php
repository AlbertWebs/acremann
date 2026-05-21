<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Acremann Properties');
        $response->assertSee('Insights');
        $response->assertSee('How to Buy Land in Kenya Safely');
    }

    public function test_properties_page_loads(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

        $response = $this->get('/properties');

        $response->assertStatus(200);
        $response->assertSee('Nachu');
    }

    public function test_lead_form_submission(): void
    {
        $this->seed(\Database\Seeders\AcremannSeeder::class);

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
