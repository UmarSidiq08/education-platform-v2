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
            $table->integer('attempt_number')->default(1)->after('finished_at');
            $table->boolean('requires_approval')->default(false)->after('attempt_number');
            $table->boolean('mentor_approved')->default(false)->after('requires_approval');
            $table->timestamp('approval_requested_at')->nullable()->after('mentor_approved');
            $table->timestamp('approved_at')->nullable()->after('approval_requested_at');
            $table->text('approval_reason')->nullable()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('post_test_attempts', function (Blueprint $table) {
            $table->dropColumn([
                'attempt_number',
                'requires_approval',
                'mentor_approved',
                'approval_requested_at',
                'approved_at',
                'approval_reason'
            ]);
        });
    }
};
