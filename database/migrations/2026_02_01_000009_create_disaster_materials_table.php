<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disaster_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['teks', 'video', 'infografis', 'pdf'])->default('teks');
            $table->string('content_url')->nullable();
            $table->text('content_text')->nullable();
            $table->string('category'); // gempa, banjir, tanah_longsor, dll
            $table->integer('difficulty_level'); // 1-5 (mudah sampai sulit)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disaster_materials');
    }
};
