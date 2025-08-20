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
        Schema::table('quiz_attempts', function (Blueprint $table) {
            // Ubah finished_at menjadi nullable untuk support ongoing attempts
            $table->timestamp('finished_at')->nullable()->change();

            // Tambah index untuk query yang lebih cepat
            $table->index(['quiz_id', 'user_id', 'finished_at']);
            $table->index(['user_id', 'finished_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            // Kembalikan finished_at menjadi tidak nullable
            $table->timestamp('finished_at')->nullable(false)->change();

            // Drop indexes
            $table->dropIndex(['quiz_id', 'user_id', 'finished_at']);
            $table->dropIndex(['user_id', 'finished_at']);
        });
    }
};
