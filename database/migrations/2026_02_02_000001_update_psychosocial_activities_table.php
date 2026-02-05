<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if table exists
        if (!Schema::hasTable('psychosocial_activities')) {
            return;
        }

        Schema::table('psychosocial_activities', function (Blueprint $table) {
            // Check if old columns exist and drop them
            if (Schema::hasColumn('psychosocial_activities', 'title')) {
                try {
                    $table->dropColumn(['title', 'activity_date', 'start_time', 'end_time', 'location', 'type', 'max_participants', 'facilitator_notes']);
                } catch (\Exception $e) {
                    // Ignore if columns don't exist
                }
            }
            
            // Add new columns if they don't exist
            if (!Schema::hasColumn('psychosocial_activities', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('psychosocial_activities', 'category')) {
                $table->string('category')->nullable()->after('description');
            }
            if (!Schema::hasColumn('psychosocial_activities', 'duration_minutes')) {
                $table->integer('duration_minutes')->nullable()->after('category');
            }
        });
    }

    public function down(): void
    {
        Schema::table('psychosocial_activities', function (Blueprint $table) {
            // Drop new columns
            if (Schema::hasColumn('psychosocial_activities', 'name')) {
                $table->dropColumn(['name', 'category', 'duration_minutes']);
            }
            
            // Restore old columns
            $table->string('title')->after('id');
            $table->date('activity_date')->after('description');
            $table->time('start_time')->after('activity_date');
            $table->time('end_time')->after('start_time');
            $table->string('location')->after('end_time');
            $table->enum('type', ['konseling', 'workshop', 'grup_diskusi', 'aktivitas_kreatif'])->default('workshop')->after('location');
            $table->integer('max_participants')->nullable()->after('type');
            $table->text('facilitator_notes')->nullable()->after('max_participants');
        });
    }
};
