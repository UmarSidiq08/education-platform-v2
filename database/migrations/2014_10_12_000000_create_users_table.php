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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->enum('role', ['siswa', 'mentor', 'guru'])->default('siswa');//->after('email');
            $table->boolean('is_verified')->default(false);//->after('role');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();


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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
