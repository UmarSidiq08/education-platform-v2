<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Basic profile fields
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('profile_photo_path')->nullable();
            
            // Mentor specific fields
            $table->string('expertise')->nullable(); // e.g., "Web Development"
            $table->json('specialties')->nullable(); // e.g., ["React", "Node.js", "TypeScript"]
            $table->decimal('rating', 3, 2)->default(0.00); // Rating out of 5.00
            $table->integer('total_students')->default(0);
            $table->string('mentor_badge')->nullable(); // e.g., "Top Mentor", "AI Specialist"
            $table->string('badge_color')->nullable(); // e.g., "bg-gradient-to-r from-yellow-400 to-orange-400"
            
            // Stats fields
            $table->json('skills')->nullable();
            $table->integer('total_projects')->default(0);
            $table->integer('completed_tasks')->default(0);
            $table->integer('total_hours')->default(0);
            $table->integer('achievements')->default(0);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'location', 'bio', 'avatar', 'profile_photo_path',
                'expertise', 'specialties', 'rating', 'total_students', 
                'mentor_badge', 'badge_color', 'skills', 'total_projects', 
                'completed_tasks', 'total_hours', 'achievements'
            ]);
        });
    }
};