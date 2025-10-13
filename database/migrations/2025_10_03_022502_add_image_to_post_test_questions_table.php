<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('post_test_questions', function (Blueprint $table) {
            $table->string('image')->nullable()->after('question');
        });
    }

    public function down()
    {
        Schema::table('post_test_questions', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
