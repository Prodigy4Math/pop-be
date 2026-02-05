<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disaster_simulations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('simulation_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location');
            $table->string('disaster_type'); // gempa, banjir, dll
            $table->integer('max_participants')->nullable();
            $table->text('evaluation_notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disaster_simulations');
    }
};
