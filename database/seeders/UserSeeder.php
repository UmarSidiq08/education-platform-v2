<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad.rizki@email.com',
            'password' => Hash::make('password'),
            'phone' => '+62 812 3456 7890',
            'location' => 'Jakarta, Indonesia',
            'bio' => 'Passionate web developer dengan pengalaman 5+ tahun dalam mengembangkan aplikasi web modern menggunakan Laravel, React, dan teknologi terkini.',
            'skills' => ['Laravel', 'Vue.js', 'JavaScript', 'PHP', 'MySQL', 'Tailwind CSS'],
            'total_projects' => 24,
            'completed_tasks' => 156,
            'total_hours' => 1245,
            'achievements' => 12,
            'email_verified_at' => now(),
        ]);

        // Create some activities
        Activity::create([
            'user_id' => $user->id,
            'action' => 'Menyelesaikan project E-Commerce',
            'type' => 'success',
            'created_at' => now()->subHours(2)
        ]);

        Activity::create([
            'user_id' => $user->id,
            'action' => 'Update profile picture',
            'type' => 'info',
            'created_at' => now()->subDay()
        ]);

        Activity::create([
            'user_id' => $user->id,
            'action' => 'Bergabung dengan tim development',
            'type' => 'success',
            'created_at' => now()->subDays(3)
        ]);

        Activity::create([
            'user_id' => $user->id,
            'action' => 'Menambahkan skill React Native',
            'type' => 'info',
            'created_at' => now()->subWeek()
        ]);
    }
}