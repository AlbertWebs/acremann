<?php

namespace Tests\Feature;

use App\Models\ClientLookup;
use App\Services\ClientPortalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\Honeypot\ProtectAgainstSpam;
use Tests\TestCase;

class ClientPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            ProtectAgainstSpam::class,
            ThrottleRequests::class,
        ]);
    }

    public function test_client_portal_page_loads(): void
    {
        $this->get('/client-portal')
            ->assertOk()
            ->assertSee('Client portal', false)
            ->assertSee('clientPortalLookup', false);
    }

    public function test_title_lookup_succeeds_via_json(): void
    {
        ClientLookup::create([
            'reference_number' => 'ACR-TITLE-001',
            'lookup_type' => 'title',
            'client_phone' => '254712345678',
            'client_email' => 'title.client@example.com',
            'status_message' => 'Title search complete.',
        ]);

        $this->postJson('/client-portal/title', [
            'reference' => 'ACR-TITLE-001',
            'phone' => '0712345678',
            'email' => 'title.client@example.com',
        ])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Title search complete.',
            ]);
    }

    public function test_lookup_fails_with_wrong_email_without_leaking(): void
    {
        ClientLookup::create([
            'reference_number' => 'ACR-TITLE-001',
            'lookup_type' => 'title',
            'client_email' => 'real@client.com',
            'status_message' => 'Private status message.',
        ]);

        $this->postJson('/client-portal/title', [
            'reference' => 'ACR-TITLE-001',
            'email' => 'wrong@client.com',
        ])
            ->assertOk()
            ->assertJson([
                'success' => false,
                'message' => ClientPortalService::GENERIC_FAILURE_MESSAGE,
            ]);
    }

    public function test_reference_only_record_works_without_contact(): void
    {
        ClientLookup::create([
            'reference_number' => 'ACR-REF-ONLY',
            'lookup_type' => 'title',
            'status_message' => 'Reference-only status.',
        ]);

        $this->postJson('/client-portal/title', [
            'reference' => 'ACR-REF-ONLY',
        ])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Reference-only status.',
            ]);
    }

    public function test_payment_lookup_returns_signed_download_url_when_statement_exists(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('client-portal/statements/demo.pdf', '%PDF-1.4 demo');

        ClientLookup::create([
            'reference_number' => 'ACR-PAY-001',
            'lookup_type' => 'payment',
            'client_email' => 'pay@client.com',
            'status_message' => 'Payment current.',
            'statement_path' => 'client-portal/statements/demo.pdf',
        ]);

        $response = $this->postJson('/client-portal/payment', [
            'reference' => 'ACR-PAY-001',
            'email' => 'pay@client.com',
        ])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Payment current.',
            ]);

        $downloadUrl = $response->json('download_url');
        $this->assertNotNull($downloadUrl);

        $signedRequest = Request::create($downloadUrl);
        $this->assertTrue(URL::hasValidSignature($signedRequest));

        $this->get($downloadUrl)->assertOk();
    }
}
