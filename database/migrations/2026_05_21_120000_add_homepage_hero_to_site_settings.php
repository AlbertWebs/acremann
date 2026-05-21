<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('hero_eyebrow')->nullable()->after('tagline');
            $table->string('hero_headline')->nullable()->after('hero_eyebrow');
            $table->text('hero_description')->nullable()->after('hero_headline');
            $table->string('hero_cta_primary_label')->nullable()->after('hero_description');
            $table->string('hero_cta_primary_url')->nullable()->after('hero_cta_primary_label');
            $table->string('hero_cta_secondary_label')->nullable()->after('hero_cta_primary_url');
            $table->string('hero_cta_secondary_url')->nullable()->after('hero_cta_secondary_label');
            $table->boolean('hero_show_whatsapp_cta')->default(true)->after('hero_cta_secondary_url');
            $table->string('hero_whatsapp_label')->nullable()->after('hero_show_whatsapp_cta');
            $table->string('hero_media_mode')->default('featured_properties')->after('hero_whatsapp_label');
            $table->string('hero_image_path')->nullable()->after('hero_media_mode');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_eyebrow',
                'hero_headline',
                'hero_description',
                'hero_cta_primary_label',
                'hero_cta_primary_url',
                'hero_cta_secondary_label',
                'hero_cta_secondary_url',
                'hero_show_whatsapp_cta',
                'hero_whatsapp_label',
                'hero_media_mode',
                'hero_image_path',
            ]);
        });
    }
};
