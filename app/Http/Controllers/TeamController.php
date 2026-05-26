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
            ->leadership()
            ->firstOrFail();

        return view('team.show', [
            'settings' => $this->settings(),
            'member' => $member,
            'otherLeaders' => TeamMember::published()
                ->leadership()
                ->whereKeyNot($member->id)
                ->get(),
        ]);
    }
}
