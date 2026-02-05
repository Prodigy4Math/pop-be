<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('icon')->nullable(); // fa-icon
            $table->enum('type', ['kehadiran', 'kebugaran', 'psikososial', 'kesiapsiagaan'])->default('kehadiran');
            $table->integer('requirement_count'); // jumlah kegiatan yang diperlukan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
