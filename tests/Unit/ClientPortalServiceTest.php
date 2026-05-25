<?php

namespace Tests\Unit;

use App\Models\ClientLookup;
use App\Services\ClientPortalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientPortalServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_lookup_requires_matching_phone_and_email_when_both_registered(): void
    {
        ClientLookup::create([
            'reference_number' => 'ACR-TITLE-001',
            'lookup_type' => 'title',
            'client_phone' => '254712345678',
            'client_email' => 'title.client@example.com',
            'status_message' => 'Title search complete.',
        ]);

        $service = new ClientPortalService;

        $this->assertNotNull($service->lookupTitle('ACR-TITLE-001', '0712345678', 'title.client@example.com'));
        $this->assertNull($service->lookupTitle('ACR-TITLE-001', '0712345678', 'wrong@example.com'));
    }
}
