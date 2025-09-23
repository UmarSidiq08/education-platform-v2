<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mentors = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.mentor@education.com',
                'password' => Hash::make('password123'),
                'role' => 'mentor',
                'is_verified' => true,
                'phone' => '081234567890',
                'location' => 'Jakarta',
                'bio' => 'Experienced web developer with 5+ years in full-stack development. Passionate about teaching modern web technologies.',
                'expertise' => 'Web Development',
                'specialties' => ['Laravel', 'Vue.js', 'JavaScript', 'PHP', 'MySQL'],
                'rating' => 4.8,
                'total_students' => 45,
                'mentor_badge' => 'Top Mentor',
                'badge_color' => 'bg-gradient-to-r from-yellow-400 to-orange-400',
                'skills' => ['Laravel', 'Vue.js', 'JavaScript', 'PHP', 'MySQL', 'API Development'],
                'total_projects' => 32,
                'completed_tasks' => 158,
                'total_hours' => 240,
                'achievements' => 15,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.mentor@education.com',
                'password' => Hash::make('password123'),
                'role' => 'mentor',
                'is_verified' => true,
                'phone' => '081987654321',
                'location' => 'Bandung',
                'bio' => 'Mobile app developer specializing in React Native and Flutter. Love creating beautiful and functional mobile applications.',
                'expertise' => 'Mobile Development',
                'specialties' => ['React Native', 'Flutter', 'Dart', 'JavaScript', 'Firebase'],
                'rating' => 4.9,
                'total_students' => 38,
                'mentor_badge' => 'Mobile Expert',
                'badge_color' => 'bg-gradient-to-r from-blue-400 to-purple-400',
                'skills' => ['React Native', 'Flutter', 'Dart', 'JavaScript', 'Firebase', 'Mobile UI/UX'],
                'total_projects' => 28,
                'completed_tasks' => 142,
                'total_hours' => 220,
                'achievements' => 12,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.mentor@education.com',
                'password' => Hash::make('password123'),
                'role' => 'mentor',
                'is_verified' => true,
                'phone' => '082345678901',
                'location' => 'Surabaya',
                'bio' => 'Data scientist and AI enthusiast with expertise in machine learning and data analysis. Teaching the next generation of data professionals.',
                'expertise' => 'Data Science',
                'specialties' => ['Python', 'Machine Learning', 'TensorFlow', 'Pandas', 'SQL'],
                'rating' => 4.7,
                'total_students' => 52,
                'mentor_badge' => 'AI Specialist',
                'badge_color' => 'bg-gradient-to-r from-green-400 to-blue-400',
                'skills' => ['Python', 'Machine Learning', 'TensorFlow', 'Pandas', 'SQL', 'Data Visualization'],
                'total_projects' => 25,
                'completed_tasks' => 135,
                'total_hours' => 280,
                'achievements' => 18,
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.mentor@education.com',
                'password' => Hash::make('password123'),
                'role' => 'mentor',
                'is_verified' => true,
                'phone' => '083456789012',
                'location' => 'Yogyakarta',
                'bio' => 'UI/UX Designer with a passion for creating intuitive and beautiful user experiences. Specialized in design thinking and user research.',
                'expertise' => 'UI/UX Design',
                'specialties' => ['Figma', 'Adobe XD', 'Sketch', 'User Research', 'Prototyping'],
                'rating' => 4.6,
                'total_students' => 41,
                'mentor_badge' => 'Design Expert',
                'badge_color' => 'bg-gradient-to-r from-pink-400 to-red-400',
                'skills' => ['Figma', 'Adobe XD', 'Sketch', 'User Research', 'Prototyping', 'Design Systems'],
                'total_projects' => 35,
                'completed_tasks' => 167,
                'total_hours' => 195,
                'achievements' => 14,
            ],
            [
                'name' => 'Andi Firmansyah',
                'email' => 'andi.mentor@education.com',
                'password' => Hash::make('password123'),
                'role' => 'mentor',
                'is_verified' => true,
                'phone' => '084567890123',
                'location' => 'Medan',
                'bio' => 'DevOps engineer with extensive experience in cloud infrastructure and CI/CD pipelines. Teaching modern deployment strategies.',
                'expertise' => 'DevOps & Cloud',
                'specialties' => ['Docker', 'Kubernetes', 'AWS', 'Jenkins', 'Terraform'],
                'rating' => 4.5,
                'total_students' => 29,
                'mentor_badge' => 'Cloud Architect',
                'badge_color' => 'bg-gradient-to-r from-indigo-400 to-cyan-400',
                'skills' => ['Docker', 'Kubernetes', 'AWS', 'Jenkins', 'Terraform', 'Linux'],
                'total_projects' => 22,
                'completed_tasks' => 98,
                'total_hours' => 175,
                'achievements' => 10,
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.mentor@education.com',
                'password' => Hash::make('password123'),
                'role' => 'mentor',
                'is_verified' => true,
                'phone' => '085678901234',
                'location' => 'Makassar',
                'bio' => 'Cybersecurity specialist focusing on ethical hacking and network security. Passionate about teaching secure coding practices.',
                'expertise' => 'Cybersecurity',
                'specialties' => ['Ethical Hacking', 'Network Security', 'Penetration Testing', 'CISSP', 'ISO 27001'],
                'rating' => 4.8,
                'total_students' => 33,
                'mentor_badge' => 'Security Expert',
                'badge_color' => 'bg-gradient-to-r from-red-500 to-orange-500',
                'skills' => ['Ethical Hacking', 'Network Security', 'Penetration Testing', 'CISSP', 'ISO 27001', 'Risk Assessment'],
                'total_projects' => 18,
                'completed_tasks' => 89,
                'total_hours' => 210,
                'achievements' => 16,
            ],
            [
                'name' => 'Riko Pratama',
                'email' => 'riko.mentor@education.com',
                'password' => Hash::make('password123'),
                'role' => 'mentor',
                'is_verified' => true,
                'phone' => '086789012345',
                'location' => 'Semarang',
                'bio' => 'Full-stack JavaScript developer with expertise in Node.js and React ecosystem. Love building scalable web applications.',
                'expertise' => 'JavaScript Development',
                'specialties' => ['Node.js', 'React', 'Express.js', 'MongoDB', 'TypeScript'],
                'rating' => 4.7,
                'total_students' => 47,
                'mentor_badge' => 'JS Expert',
                'badge_color' => 'bg-gradient-to-r from-yellow-300 to-green-400',
                'skills' => ['Node.js', 'React', 'Express.js', 'MongoDB', 'TypeScript', 'GraphQL'],
                'total_projects' => 30,
                'completed_tasks' => 145,
                'total_hours' => 260,
                'achievements' => 13,
            ],
            [
                'name' => 'Indira Sari',
                'email' => 'indira.mentor@education.com',
                'password' => Hash::make('password123'),
                'role' => 'mentor',
                'is_verified' => true,
                'phone' => '087890123456',
                'location' => 'Palembang',
                'bio' => 'Game developer with experience in Unity and Unreal Engine. Teaching game design principles and development techniques.',
                'expertise' => 'Game Development',
                'specialties' => ['Unity', 'C#', 'Unreal Engine', 'Blender', 'Game Design'],
                'rating' => 4.6,
                'total_students' => 26,
                'mentor_badge' => 'Game Master',
                'badge_color' => 'bg-gradient-to-r from-purple-500 to-pink-500',
                'skills' => ['Unity', 'C#', 'Unreal Engine', 'Blender', 'Game Design', '3D Modeling'],
                'total_projects' => 15,
                'completed_tasks' => 78,
                'total_hours' => 185,
                'achievements' => 9,
            ]
        ];

        foreach ($mentors as $mentorData) {
            $existingMentor = User::where('email', $mentorData['email'])
                ->orWhere('name', $mentorData['name'])
                ->first();
            
            if (!$existingMentor) {
                User::create($mentorData);
            }
        }

        $this->command->info('✅ Mentor seeder completed successfully!');
        $this->command->info('📊 ' . count($mentors) . ' mentors have been created.');
    }
}