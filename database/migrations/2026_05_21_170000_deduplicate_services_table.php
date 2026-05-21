<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $canonicalSlugs = [
            'land-sales',
            'investment-advisory',
            'conveyancing',
            'diaspora-support',
        ];

        foreach ($canonicalSlugs as $slug) {
            $rows = DB::table('services')
                ->where('slug', $slug)
                ->orWhere('slug', 'like', $slug.'-%')
                ->orderByRaw('CASE WHEN slug = ? THEN 0 ELSE 1 END', [$slug])
                ->orderByRaw('LENGTH(COALESCE(body, "")) DESC')
                ->orderBy('id')
                ->get();

            if ($rows->count() <= 1) {
                continue;
            }

            $keepId = $rows->first()->id;

            DB::table('services')
                ->where(function ($query) use ($slug) {
                    $query->where('slug', $slug)
                        ->orWhere('slug', 'like', $slug.'-%');
                })
                ->where('id', '!=', $keepId)
                ->delete();
        }
    }

    public function down(): void
    {
        // Irreversible cleanup.
    }
};
