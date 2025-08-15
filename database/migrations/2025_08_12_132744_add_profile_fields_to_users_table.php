<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->json('skills')->nullable();
            $table->integer('total_projects')->default(0);
            $table->integer('completed_tasks')->default(0);
            $table->integer('total_hours')->default(0);
            $table->integer('achievements')->default(0);
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_photo_path')->nullable();
            });
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'location', 'bio', 'avatar', 'skills',
                'total_projects', 'completed_tasks', 'total_hours', 'achievements'
            ]);
            
        });
    }

    
};
