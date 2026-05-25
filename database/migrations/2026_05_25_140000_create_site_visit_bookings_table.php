<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visit_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->string('buyer_type')->nullable();
            $table->string('budget')->nullable();
            $table->string('property_interest')->nullable();
            $table->text('message')->nullable();
            $table->boolean('consent_callback')->default(false);
            $table->boolean('consent_whatsapp')->default(false);
            $table->boolean('consent_email')->default(false);
            $table->boolean('consent_marketing')->default(false);
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_visit_bookings');
    }
};
