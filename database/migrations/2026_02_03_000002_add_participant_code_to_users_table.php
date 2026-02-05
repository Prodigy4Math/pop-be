<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('sport_interest_id')->nullable()->constrained('sports')->nullOnDelete();
            $table->string('participant_code')->nullable()->unique();
            $table->longText('barcode_svg')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sport_interest_id']);
            $table->dropColumn(['sport_interest_id', 'participant_code', 'barcode_svg']);
        });
    }
};
