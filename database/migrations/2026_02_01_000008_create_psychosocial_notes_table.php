<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('psychosocial_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('activity_id')->nullable()->constrained('psychosocial_activities')->onDelete('set null');
            $table->date('note_date');
            $table->text('observations');
            $table->text('emotional_state')->nullable();
            $table->integer('resilience_score'); // 1-10
            $table->integer('coping_ability'); // 1-10
            $table->text('recommendations')->nullable();
            $table->text('facilitator_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psychosocial_notes');
    }
};
