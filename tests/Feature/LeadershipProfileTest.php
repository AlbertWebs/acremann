<?php

namespace Tests\Feature;

use App\Models\TeamMember;
use Database\Seeders\AcremannSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadershipProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_leadership_profile_page_renders(): void
    {
        $this->seed(AcremannSeeder::class);

        $leader = TeamMember::query()
            ->where('is_leadership', true)
            ->where('is_published', true)
            ->firstOrFail();

        $response = $this->get(route('leadership.show', $leader));

        $response->assertOk();
        $response->assertSee($leader->name, false);
        $response->assertSee('Other leaders', false);
    }
}
