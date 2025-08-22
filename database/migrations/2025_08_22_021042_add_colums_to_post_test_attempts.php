<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('post_test_attempts', function (Blueprint $table) {
            // Field untuk menandakan apakah ini attempt setelah approval
            $table->boolean('is_approval_attempt')->default(false)->after('approval_reason');

            // Field untuk menandakan apakah approval sudah digunakan
            $table->boolean('is_used')->default(false)->after('is_approval_attempt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_test_attempts', function (Blueprint $table) {
            $table->dropColumn(['is_approval_attempt', 'is_used']);
        });
    }
};
