<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLegalPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_privacy_editor_loads_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/legal/legal-pages/privacy')
            ->assertOk();
    }

    public function test_admin_terms_editor_loads_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/legal/legal-pages/terms')
            ->assertOk();
    }
}
