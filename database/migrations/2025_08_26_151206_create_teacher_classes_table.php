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
        Schema::create('teacher_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // contoh: "Matematika"
            $table->string('subject')->nullable(); // contoh: "Matematika Dasar"
            $table->text('description')->nullable();
            $table->unsignedBigInteger('teacher_id'); // User yang role guru
            $table->timestamps();

            // Foreign key ke users table
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');

            // Index untuk performance
            $table->index('teacher_id');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_classes');
    }
};
