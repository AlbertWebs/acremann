<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assistant_menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('action');
            $table->string('journey')->nullable();
            $table->string('lead_form_title')->nullable();
            $table->string('url')->nullable();
            $table->boolean('open_in_new_tab')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('assistant_heading')->nullable()->after('hero_image_path');
            $table->string('assistant_subheading')->nullable()->after('assistant_heading');
            $table->text('assistant_title_body')->nullable()->after('assistant_subheading');
            $table->string('assistant_title_link_label')->nullable()->after('assistant_title_body');
            $table->string('assistant_title_link_url')->nullable()->after('assistant_title_link_label');
            $table->string('assistant_whatsapp_label')->nullable()->after('assistant_title_link_url');
            $table->text('assistant_consent_text')->nullable()->after('assistant_whatsapp_label');
            $table->string('assistant_success_message')->nullable()->after('assistant_consent_text');
            $table->json('assistant_buyer_types')->nullable()->after('assistant_success_message');
            $table->json('assistant_budget_ranges')->nullable()->after('assistant_buyer_types');
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->boolean('show_in_assistant')->default(false)->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('show_in_assistant');
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'assistant_heading',
                'assistant_subheading',
                'assistant_title_body',
                'assistant_title_link_label',
                'assistant_title_link_url',
                'assistant_whatsapp_label',
                'assistant_consent_text',
                'assistant_success_message',
                'assistant_buyer_types',
                'assistant_budget_ranges',
            ]);
        });

        Schema::dropIfExists('assistant_menu_items');
    }
};
