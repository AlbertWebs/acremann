<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const LONG_INTRO = 'Responsible land use, green open spaces, solar-ready planning, and long-term community value guide every Acremann development. Beyond marketing claims, we plan tree planting, drainage improvements, and protected open space from the earliest master-plan stage — so infrastructure, access, and environmental choices support families and investors for decades. Whether you are buying to build, hold, or pass land to the next generation, our sustainability markers are documented on every project we represent across Nairobi, Kiambu, Kikuyu and Nachu.';

    private const SHORT_INTRO = 'Responsible land use, green open spaces, and solar-ready planning guide every Acremann development. We plan tree planting, drainage, and protected open space from the start, with clear sustainability markers on every project across Nairobi, Kiambu, Kikuyu and Nachu.';

    public function up(): void
    {
        DB::table('site_settings')
            ->where('sustainability_intro', self::LONG_INTRO)
            ->update(['sustainability_intro' => self::SHORT_INTRO]);

        DB::table('site_settings')
            ->where('sustainability_intro', 'like', '%Beyond marketing claims%')
            ->update(['sustainability_intro' => self::SHORT_INTRO]);
    }

    public function down(): void
    {
        DB::table('site_settings')
            ->where('sustainability_intro', self::SHORT_INTRO)
            ->update(['sustainability_intro' => self::LONG_INTRO]);
    }
};
