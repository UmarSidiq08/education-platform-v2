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
        Schema::create('mentor_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mentor_id'); // User yang role mentor
            $table->unsignedBigInteger('teacher_class_id'); // TeacherClass yang ingin diikuti
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('message')->nullable(); // Pesan dari mentor (opsional)
            $table->timestamp('requested_at'); // Kapan request dibuat
            $table->timestamp('approved_at')->nullable(); // Kapan di-approve
            $table->timestamp('rejected_at')->nullable(); // Kapan di-reject
            $table->unsignedBigInteger('approved_by')->nullable(); // Siapa yang approve (teacher_id)
            $table->timestamps();

            // Foreign keys
            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teacher_class_id')->references('id')->on('teacher_classes')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');

            // Indexes untuk performance
            $table->index('mentor_id');
            $table->index('teacher_class_id');
            $table->index('status');
            $table->index('requested_at');

            // Unique constraint: satu mentor hanya bisa request sekali per teacher_class
            $table->unique(['mentor_id', 'teacher_class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_requests');
    }
};
