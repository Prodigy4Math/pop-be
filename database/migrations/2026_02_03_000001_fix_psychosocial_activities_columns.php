<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('psychosocial_activities')) {
            return;
        }

        Schema::table('psychosocial_activities', function (Blueprint $table) {
            if (!Schema::hasColumn('psychosocial_activities', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('psychosocial_activities', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('psychosocial_activities', 'duration_minutes')) {
                $table->integer('duration_minutes')->nullable();
            }
        });

        if (
            Schema::hasColumn('psychosocial_activities', 'title') &&
            Schema::hasColumn('psychosocial_activities', 'name')
        ) {
            DB::statement('UPDATE psychosocial_activities SET name = title WHERE name IS NULL');
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('psychosocial_activities')) {
            return;
        }

        Schema::table('psychosocial_activities', function (Blueprint $table) {
            if (Schema::hasColumn('psychosocial_activities', 'duration_minutes')) {
                $table->dropColumn('duration_minutes');
            }
            if (Schema::hasColumn('psychosocial_activities', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('psychosocial_activities', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
