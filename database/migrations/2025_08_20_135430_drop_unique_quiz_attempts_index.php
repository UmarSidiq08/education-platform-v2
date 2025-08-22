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
    Schema::table('quiz_attempts', function (Blueprint $table) {
        $table->dropUnique('quiz_attempts_quiz_id_user_id_unique');
    });
}

public function down()
{
    Schema::table('quiz_attempts', function (Blueprint $table) {
        $table->unique(['quiz_id', 'user_id']);
    });
}

};
