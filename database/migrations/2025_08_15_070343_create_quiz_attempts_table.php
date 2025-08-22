<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('answers'); // menyimpan jawaban user
            $table->integer('score');
            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->timestamp('started_at');
            $table->timestamp('finished_at');
            $table->timestamps();

            // User hanya bisa attempt sekali per quiz
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
