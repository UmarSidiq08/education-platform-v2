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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('mentor_id'); // User yang jadi mentor
            $table->timestamps();

            // Foreign key ke users table
            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('cascade');

            // Index untuk performance
            $table->index('mentor_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
    
};
