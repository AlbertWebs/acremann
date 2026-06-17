<?php

namespace Tests\Feature;

use Database\Seeders\AcremannSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoMetaTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_includes_enhanced_seo_tags_and_local_business_schema(): void
    {
        $this->seed(AcremannSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('<meta name="keywords"', false);
        $response->assertSee('<meta name="twitter:card"', false);
        $response->assertSee('<meta property="og:locale"', false);
        $response->assertSee('<meta name="geo.position"', false);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('RealEstateAgent', false);
        $response->assertSee('LocalBusiness', false);
        $response->assertSee('-1.2710368', false);
        $response->assertSee('36.8444699', false);
        $response->assertSee('WebSite', false);
        $response->assertSee('WebPage', false);
    }

    public function test_contact_page_has_unique_meta_description(): void
    {
        $this->seed(AcremannSeeder::class);

        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contact Acremann', false);
        $response->assertSee('WhatsApp Acremann Properties in Nairobi', false);
    }

    public function test_faqs_page_includes_faq_schema_when_faqs_exist(): void
    {
        $this->seed(AcremannSeeder::class);

        $response = $this->get('/faqs');

        $response->assertStatus(200);
        $response->assertSee('FAQPage', false);
        $response->assertSee('Question', false);
    }
}
