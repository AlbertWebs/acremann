<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateKeys = DB::table('testimonials')
            ->select('client_name', 'sort_order')
            ->groupBy('client_name', 'sort_order')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicateKeys as $key) {
            $rows = DB::table('testimonials')
                ->where('client_name', $key->client_name)
                ->where('sort_order', $key->sort_order)
                ->orderByRaw('LENGTH(COALESCE(quote, "")) DESC')
                ->orderBy('id')
                ->get();

            if ($rows->count() <= 1) {
                continue;
            }

            $keepId = $rows->first()->id;

            DB::table('testimonials')
                ->where('client_name', $key->client_name)
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
