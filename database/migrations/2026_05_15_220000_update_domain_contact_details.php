<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')
            ->where('email', 'info@acremann.co.ke')
            ->update([
                'email' => 'info@acremannproperties.com',
                'phone' => '0115 874 901',
                'whatsapp' => '254115874901',
            ]);

        $privacy = DB::table('pages')->where('slug', 'privacy')->value('content');

        if (is_string($privacy)) {
            DB::table('pages')->where('slug', 'privacy')->update([
                'content' => str_replace('info@acremann.co.ke', 'info@acremannproperties.com', $privacy),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('site_settings')
            ->where('email', 'info@acremannproperties.com')
            ->update([
                'email' => 'info@acremann.co.ke',
                'phone' => '+254 712 345 678',
                'whatsapp' => '254712345678',
            ]);

        $privacy = DB::table('pages')->where('slug', 'privacy')->value('content');

        if (is_string($privacy)) {
            DB::table('pages')->where('slug', 'privacy')->update([
                'content' => str_replace('info@acremannproperties.com', 'info@acremann.co.ke', $privacy),
            ]);
        }
    }
};
