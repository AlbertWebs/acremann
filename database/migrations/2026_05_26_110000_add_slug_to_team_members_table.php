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
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        $used = [];

        foreach (DB::table('team_members')->orderBy('id')->get() as $member) {
            $base = Str::slug($member->name) ?: 'team-member-'.$member->id;
            $slug = $base;
            $suffix = 2;

            while (in_array($slug, $used, true)) {
                $slug = $base.'-'.$suffix;
                $suffix++;
            }

            $used[] = $slug;

            DB::table('team_members')->where('id', $member->id)->update(['slug' => $slug]);
        }

        Schema::table('team_members', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
