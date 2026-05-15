<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('status')->default('available');
            $table->string('project_status')->default('selling');
            $table->decimal('price_from', 14, 2)->nullable();
            $table->string('price_label')->nullable();
            $table->string('plot_size')->nullable();
            $table->string('location');
            $table->string('county')->nullable();
            $table->string('category')->default('residential');
            $table->string('title_type')->default('freehold');
            $table->string('listing_type')->default('sale');
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->json('amenities')->nullable();
            $table->text('map_embed')->nullable();
            $table->text('distance_notes')->nullable();
            $table->string('tour_embed_url')->nullable();
            $table->string('brochure_path')->nullable();
            $table->longText('title_process')->nullable();
            $table->longText('investor_angle')->nullable();
            $table->json('sustainability_markers')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('plots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('plot_number');
            $table->string('status')->default('available');
            $table->string('size')->nullable();
            $table->decimal('price', 14, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('property_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->text('bio')->nullable();
            $table->string('photo_path')->nullable();
            $table->boolean('is_leadership')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->text('quote');
            $table->string('client_name');
            $table->string('client_detail')->nullable();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->string('featured_image')->nullable();
            $table->string('author')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('link')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->json('blocks')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('category')->default('general');
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->string('buyer_type')->nullable();
            $table->string('budget')->nullable();
            $table->string('location_preference')->nullable();
            $table->string('property_interest')->nullable();
            $table->text('message')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('consent_callback')->default(false);
            $table->boolean('consent_whatsapp')->default(false);
            $table->boolean('consent_email')->default(false);
            $table->boolean('consent_marketing')->default(false);
            $table->string('status')->default('new');
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->json('preferences')->nullable();
            $table->boolean('consent_marketing')->default(false);
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('Acremann Properties');
            $table->string('tagline')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->text('about_summary')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('podcast_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->text('csr_statement')->nullable();
            $table->text('referral_program')->nullable();
            $table->text('sustainability_intro')->nullable();
            $table->text('investment_intro')->nullable();
            $table->string('ga_measurement_id')->nullable();
            $table->string('gtm_container_id')->nullable();
            $table->string('meta_pixel_id')->nullable();
            $table->timestamps();
        });

        Schema::create('client_lookups', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->string('lookup_type');
            $table->string('client_name')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();
            $table->string('status_message');
            $table->string('statement_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_lookups');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('services');
        Schema::dropIfExists('certifications');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('property_faqs');
        Schema::dropIfExists('plots');
        Schema::dropIfExists('properties');
    }
};
