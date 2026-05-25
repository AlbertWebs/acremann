<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateTitles = DB::table('certifications')
            ->select('title')
            ->groupBy('title')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('title');

        foreach ($duplicateTitles as $title) {
            $rows = DB::table('certifications')
                ->where('title', $title)
                ->orderByRaw('LENGTH(COALESCE(description, "")) DESC')
                ->orderByRaw('CASE WHEN logo_path IS NOT NULL AND logo_path != "" THEN 0 ELSE 1 END')
                ->orderBy('id')
                ->get();

            if ($rows->count() <= 1) {
                continue;
            }

            $keepId = $rows->first()->id;

            DB::table('certifications')
                ->where('title', $title)
                ->where('id', '!=', $keepId)
                ->delete();
        }
    }

    public function down(): void
    {
        // Irreversible cleanup.
    }
};
