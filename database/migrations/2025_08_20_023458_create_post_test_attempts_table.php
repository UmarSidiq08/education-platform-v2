<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('post_test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_test_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('answers')->nullable();
            $table->integer('score')->default(0);
            $table->integer('total_questions')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->integer('time_remaining')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->unique(['post_test_id', 'user_id']);
               $table->integer('attempt_number')->default(1);
            $table->boolean('requires_approval')->default(false);
            $table->boolean('mentor_approved')->default(false);
            $table->timestamp('approval_requested_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_reason')->nullable();

             $table->boolean('is_approval_attempt')->default(false);

            // Field untuk menandakan apakah approval sudah digunakan
            $table->boolean('is_used')->default(false);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_test_attempts');
    }
};
