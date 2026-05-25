<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('services_page_eyebrow')->nullable()->after('investment_intro');
            $table->string('services_page_headline')->nullable()->after('services_page_eyebrow');
            $table->text('services_page_lead')->nullable()->after('services_page_headline');
            $table->string('services_page_section_title')->nullable()->after('services_page_lead');
            $table->text('services_page_section_lead')->nullable()->after('services_page_section_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'services_page_eyebrow',
                'services_page_headline',
                'services_page_lead',
                'services_page_section_title',
                'services_page_section_lead',
            ]);
        });
    }
};
