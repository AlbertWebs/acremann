<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('hero_video_enabled')->default(false)->after('hero_images');
            $table->string('hero_video_provider')->nullable()->after('hero_video_enabled');
            $table->string('hero_video_url')->nullable()->after('hero_video_provider');
            $table->string('hero_video_path')->nullable()->after('hero_video_url');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_video_enabled',
                'hero_video_provider',
                'hero_video_url',
                'hero_video_path',
            ]);
        });
    }
};
