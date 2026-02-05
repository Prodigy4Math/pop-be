<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('psychosocial_activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('activity_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location');
            $table->enum('type', ['konseling', 'workshop', 'grup_diskusi', 'aktivitas_kreatif'])->default('workshop');
            $table->integer('max_participants')->nullable();
            $table->text('facilitator_notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psychosocial_activities');
    }
};
