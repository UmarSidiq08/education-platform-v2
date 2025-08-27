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
        Schema::table('classes', function (Blueprint $table) {
            // Tambah kolom teacher_class_id
            $table->unsignedBigInteger('teacher_class_id')->nullable()->after('mentor_id');

            // Foreign key ke teacher_classes
            $table->foreign('teacher_class_id')->references('id')->on('teacher_classes')->onDelete('set null');

            // Index untuk performance
            $table->index('teacher_class_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['teacher_class_id']);
            $table->dropIndex(['teacher_class_id']);
            $table->dropColumn('teacher_class_id');
        });
    }
};
