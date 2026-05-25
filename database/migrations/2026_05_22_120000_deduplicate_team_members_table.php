<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateKeys = DB::table('team_members')
            ->select('name', 'sort_order')
            ->groupBy('name', 'sort_order')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicateKeys as $key) {
            $rows = DB::table('team_members')
                ->where('name', $key->name)
                ->where('sort_order', $key->sort_order)
                ->orderByRaw('LENGTH(COALESCE(bio, "")) DESC')
                ->orderByRaw('CASE WHEN photo_path IS NOT NULL AND photo_path != "" THEN 0 ELSE 1 END')
                ->orderBy('id')
                ->get();

            if ($rows->count() <= 1) {
                continue;
            }

            $keepId = $rows->first()->id;

            DB::table('team_members')
                ->where('name', $key->name)
                ->where('sort_order', $key->sort_order)
                ->where('id', '!=', $keepId)
                ->delete();
        }
    }

    public function down(): void
    {
        // Irreversible cleanup.
    }
};
