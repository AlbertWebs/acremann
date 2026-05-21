<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assistant_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('status')->default('exploring');
            $table->string('journey')->nullable();
            $table->string('last_step')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('buyer_type')->nullable();
            $table->string('budget')->nullable();
            $table->text('message')->nullable();
            $table->string('page_url')->nullable();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('event_count')->default(0);
            $table->json('transcript')->nullable();
            $table->json('metadata')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('last_activity_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistant_sessions');
    }
};
