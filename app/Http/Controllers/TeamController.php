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

        $otherMembersQuery = TeamMember::published()->whereKeyNot($member->id);

        if ($member->is_leadership) {
            $otherMembersQuery->leadership();
        } else {
            $otherMembersQuery->where('is_leadership', false);
        }

        return view('team.show', [
            'settings' => $this->settings(),
            'member' => $member,
            'otherMembers' => $otherMembersQuery->get(),
        ]);
    }
}
