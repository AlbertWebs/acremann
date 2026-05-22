<?php

namespace Tests\Feature;

use App\Enums\AdminRole;
use App\Filament\Resources\AdminAccounts\AdminAccountResource;
use App\Filament\Resources\ClientLookups\ClientLookupResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_users_default_to_super_admin(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($user->fresh()->isSuperAdmin());
        $this->assertTrue($user->canAccessFinance());
    }

    public function test_normal_admin_cannot_access_finance_resource(): void
    {
        $user = User::factory()->normalAdmin()->create();

        $this->actingAs($user);

        $this->assertFalse(ClientLookupResource::canAccess());
    }

    public function test_super_admin_can_access_finance_resource(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertTrue(ClientLookupResource::canAccess());
    }

    public function test_normal_admin_cannot_access_admin_accounts(): void
    {
        $user = User::factory()->normalAdmin()->create();

        $this->actingAs($user);

        $this->assertFalse(AdminAccountResource::canAccess());
    }

    public function test_super_admin_can_access_admin_accounts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertTrue(AdminAccountResource::canAccess());
    }

    public function test_admin_accounts_page_requires_super_admin(): void
    {
        $user = User::factory()->normalAdmin()->create();

        $this->actingAs($user)
            ->get(AdminAccountResource::getUrl('index'))
            ->assertForbidden();
    }

    public function test_finance_page_requires_super_admin(): void
    {
        $user = User::factory()->normalAdmin()->create();

        $this->actingAs($user)
            ->get(ClientLookupResource::getUrl('index'))
            ->assertForbidden();
    }

    public function test_admin_role_is_persisted(): void
    {
        $user = User::factory()->create([
            'admin_role' => AdminRole::Admin,
        ]);

        $this->assertSame(AdminRole::Admin, $user->admin_role);
        $this->assertFalse($user->isSuperAdmin());
    }
}
