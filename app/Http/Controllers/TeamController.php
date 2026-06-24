<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;

class TeamController extends Controller
{
    public function leadership()
    {
        return view('team.leadership', [
            'settings' => $this->settings(),
            'leadership' => TeamMember::published()->leadership()->get(),
        ]);
    }

    public function show(string $slug)
    {
        $member = TeamMember::query()
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $otherLeadersQuery = TeamMember::published()->whereKeyNot($member->id);

        if ($member->is_leadership) {
            $otherLeadersQuery->leadership();
        } else {
            $otherLeadersQuery->where('is_leadership', false);
        }

        return view('team.show', [
            'settings' => $this->settings(),
            'member' => $member,
            'otherLeaders' => $otherLeadersQuery->get(),
        ]);
    }
}
