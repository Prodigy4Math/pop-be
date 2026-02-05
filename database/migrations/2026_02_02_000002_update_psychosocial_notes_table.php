<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if table exists
        if (!Schema::hasTable('psychosocial_notes')) {
            return;
        }

        // Drop old foreign keys before altering columns (avoid migration failure on missing FK names)
        if (Schema::hasColumn('psychosocial_notes', 'activity_id')) {
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = 'psychosocial_notes'
                   AND COLUMN_NAME = 'activity_id'
                   AND REFERENCED_TABLE_NAME IS NOT NULL"
            );

            foreach ($foreignKeys as $fk) {
                try {
                    DB::statement("ALTER TABLE `psychosocial_notes` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
                } catch (\Exception $e) {
                    // Ignore if foreign key doesn't exist
                }
            }
        }

        Schema::table('psychosocial_notes', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('psychosocial_notes', 'activity_id')) {
                $columnsToDrop = ['activity_id', 'note_date', 'observations', 'emotional_state', 'coping_ability', 'recommendations', 'facilitator_name'];
                $existingColumns = [];
                foreach ($columnsToDrop as $col) {
                    if (Schema::hasColumn('psychosocial_notes', $col)) {
                        $existingColumns[] = $col;
                    }
                }
                if (!empty($existingColumns)) {
                    $table->dropColumn($existingColumns);
                }
            }
            
            // Add new columns if they don't exist
            if (!Schema::hasColumn('psychosocial_notes', 'psychosocial_activity_id')) {
                try {
                    $table->foreignId('psychosocial_activity_id')->nullable()->after('user_id')->constrained('psychosocial_activities')->onDelete('set null');
                } catch (\Exception $e) {
                    // If foreign key fails, add column without constraint first
                    $table->unsignedBigInteger('psychosocial_activity_id')->nullable()->after('user_id');
                }
            }
            if (!Schema::hasColumn('psychosocial_notes', 'notes')) {
                $table->text('notes')->nullable()->after('psychosocial_activity_id');
            }
            if (!Schema::hasColumn('psychosocial_notes', 'mood')) {
                $table->string('mood')->nullable()->after('resilience_score');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('psychosocial_notes', 'psychosocial_activity_id')) {
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = 'psychosocial_notes'
                   AND COLUMN_NAME = 'psychosocial_activity_id'
                   AND REFERENCED_TABLE_NAME IS NOT NULL"
            );

            foreach ($foreignKeys as $fk) {
                try {
                    DB::statement("ALTER TABLE `psychosocial_notes` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
                } catch (\Exception $e) {
                    // Ignore if foreign key doesn't exist
                }
            }
        }

        Schema::table('psychosocial_notes', function (Blueprint $table) {
            // Drop new columns
            if (Schema::hasColumn('psychosocial_notes', 'psychosocial_activity_id')) {
                try {
                    $table->dropColumn(['psychosocial_activity_id', 'notes', 'mood']);
                } catch (\Exception $e) {
                    // Ignore if columns don't exist
                }
            }
            
            // Restore old columns
            $table->foreignId('activity_id')->nullable()->after('user_id')->constrained('psychosocial_activities')->onDelete('set null');
            $table->date('note_date')->after('activity_id');
            $table->text('observations')->after('note_date');
            $table->text('emotional_state')->nullable()->after('observations');
            $table->integer('coping_ability')->after('resilience_score');
            $table->text('recommendations')->nullable()->after('coping_ability');
            $table->text('facilitator_name')->nullable()->after('recommendations');
        });
    }
};
