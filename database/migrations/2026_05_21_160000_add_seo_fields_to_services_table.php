<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('services', 'slug')) {
            Schema::table('services', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('title');
                $table->string('meta_title')->nullable()->after('body');
                $table->text('meta_description')->nullable()->after('meta_title');
                $table->text('local_summary')->nullable()->after('meta_description');
                $table->text('diaspora_summary')->nullable()->after('local_summary');
            });
        }

        $slugMap = [
            'Land Sales' => 'land-sales',
            'Investment Advisory' => 'investment-advisory',
            'Conveyancing' => 'conveyancing',
            'Diaspora Support' => 'diaspora-support',
        ];

        foreach (DB::table('services')->orderBy('id')->get() as $service) {
            if (filled($service->slug)) {
                continue;
            }

            $base = $slugMap[$service->title] ?? Str::slug($service->title);
            $slug = $base;
            $suffix = 2;

            while (
                DB::table('services')
                    ->where('slug', $slug)
                    ->where('id', '!=', $service->id)
                    ->exists()
            ) {
                $slug = "{$base}-{$suffix}";
                $suffix++;
            }

            DB::table('services')
                ->where('id', $service->id)
                ->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'meta_title',
                'meta_description',
                'local_summary',
                'diaspora_summary',
            ]);
        });
    }
};
