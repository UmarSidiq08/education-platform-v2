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
        Schema::table('post_test_attempts', function (Blueprint $table) {
            // 1. Hapus foreign key constraint sementara
            $table->dropForeign(['post_test_id']);
            $table->dropForeign(['user_id']);

            // 2. Hapus unique constraint
            $table->dropUnique(['post_test_id', 'user_id']);

            // 3. Tambahkan kembali foreign key constraint
            $table->foreign('post_test_id')->references('id')->on('post_tests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('post_test_attempts', function (Blueprint $table) {
            // 1. Hapus foreign key constraint sementara
            $table->dropForeign(['post_test_id']);
            $table->dropForeign(['user_id']);

            // 2. Tambahkan kembali unique constraint
            $table->unique(['post_test_id', 'user_id']);

            // 3. Tambahkan kembali foreign key constraint
            $table->foreign('post_test_id')->references('id')->on('post_tests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
