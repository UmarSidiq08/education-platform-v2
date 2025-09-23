<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\TeacherClass;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get mentors and teachers
        $mentors = User::where('role', 'mentor')->get();
        $teachers = User::where('role', 'guru')->get();
        $teacherClasses = TeacherClass::all();

        if ($mentors->isEmpty()) {
            $this->command->warn('⚠️  No mentors found. Please run MentorSeeder first.');
            return;
        }

        // Create classes data
        $classesData = [
            // Web Development Classes
            [
                'name' => 'Laravel Fundamental',
                'description' => 'Pelajari dasar-dasar Laravel framework untuk membangun aplikasi web yang powerful. Mulai dari routing, blade templating, hingga database dengan Eloquent ORM.',
                'expertise' => 'Web Development',
            ],
            [
                'name' => 'Vue.js for Beginners',
                'description' => 'Membangun user interface yang reaktif dengan Vue.js. Pelajari component-based development, state management, dan integrasi dengan API.',
                'expertise' => 'Web Development',
            ],
            [
                'name' => 'Full-Stack JavaScript',
                'description' => 'Kelas lengkap untuk menjadi full-stack JavaScript developer. Pelajari Node.js, Express, dan integrasi frontend-backend.',
                'expertise' => 'JavaScript Development',
            ],
            [
                'name' => 'API Development with Laravel',
                'description' => 'Membangun RESTful API yang robust dengan Laravel. Pelajari authentication, validation, dan best practices dalam API development.',
                'expertise' => 'Web Development',
            ],

            // Mobile Development Classes
            [
                'name' => 'React Native Essentials',
                'description' => 'Bangun aplikasi mobile cross-platform dengan React Native. Pelajari navigation, state management, dan native modules.',
                'expertise' => 'Mobile Development',
            ],
            [
                'name' => 'Flutter for Mobile Apps',
                'description' => 'Kelas komprehensif Flutter development. Dari widget basics hingga state management dengan Provider dan Bloc.',
                'expertise' => 'Mobile Development',
            ],
            [
                'name' => 'Mobile UI/UX Design',
                'description' => 'Prinsip-prinsip design untuk mobile application. Pelajari user experience patterns dan best practices untuk mobile interface.',
                'expertise' => 'Mobile Development',
            ],

            // Data Science Classes
            [
                'name' => 'Python for Data Science',
                'description' => 'Mulai journey data science dengan Python. Pelajari pandas, numpy, dan visualization libraries untuk data analysis.',
                'expertise' => 'Data Science',
            ],
            [
                'name' => 'Machine Learning Fundamentals',
                'description' => 'Konsep dasar machine learning dan implementasinya dengan scikit-learn. Dari supervised hingga unsupervised learning.',
                'expertise' => 'Data Science',
            ],
            [
                'name' => 'Deep Learning with TensorFlow',
                'description' => 'Membangun neural networks dengan TensorFlow. Pelajari CNN, RNN, dan aplikasinya dalam computer vision dan NLP.',
                'expertise' => 'Data Science',
            ],
            [
                'name' => 'Data Visualization Mastery',
                'description' => 'Membuat visualisasi data yang compelling dengan matplotlib, seaborn, dan plotly. Storytelling with data.',
                'expertise' => 'Data Science',
            ],

            // UI/UX Design Classes
            [
                'name' => 'UI Design Fundamentals',
                'description' => 'Dasar-dasar user interface design. Pelajari typography, color theory, dan layout principles untuk digital products.',
                'expertise' => 'UI/UX Design',
            ],
            [
                'name' => 'User Experience Research',
                'description' => 'Metodologi penelitian UX yang comprehensive. Dari user interviews hingga usability testing dan data analysis.',
                'expertise' => 'UI/UX Design',
            ],
            [
                'name' => 'Figma Design Systems',
                'description' => 'Membangun design system yang scalable dengan Figma. Component libraries, style guides, dan collaboration workflows.',
                'expertise' => 'UI/UX Design',
            ],
            [
                'name' => 'Prototyping & Wireframing',
                'description' => 'Teknik prototyping dari lo-fi hingga hi-fi. Tools dan methodologies untuk effective design communication.',
                'expertise' => 'UI/UX Design',
            ],

            // DevOps & Cloud Classes
            [
                'name' => 'Docker Containerization',
                'description' => 'Containerize aplikasi dengan Docker. Pelajari Dockerfile, docker-compose, dan container orchestration basics.',
                'expertise' => 'DevOps & Cloud',
            ],
            [
                'name' => 'AWS Cloud Fundamentals',
                'description' => 'Pengenalan Amazon Web Services. EC2, S3, RDS, dan layanan cloud computing essential lainnya.',
                'expertise' => 'DevOps & Cloud',
            ],
            [
                'name' => 'CI/CD Pipeline Setup',
                'description' => 'Membangun automated deployment pipeline. Jenkins, GitHub Actions, dan continuous integration best practices.',
                'expertise' => 'DevOps & Cloud',
            ],

            // Cybersecurity Classes
            [
                'name' => 'Ethical Hacking Basics',
                'description' => 'Pengenalan ethical hacking dan penetration testing. Tools, methodologies, dan legal aspects dalam cybersecurity.',
                'expertise' => 'Cybersecurity',
            ],
            [
                'name' => 'Network Security Fundamentals',
                'description' => 'Keamanan jaringan komputer. Firewall configuration, VPN setup, dan network vulnerability assessment.',
                'expertise' => 'Cybersecurity',
            ],
            [
                'name' => 'Secure Coding Practices',
                'description' => 'Praktik coding yang aman. OWASP Top 10, input validation, dan security testing dalam software development.',
                'expertise' => 'Cybersecurity',
            ],

            // Game Development Classes
            [
                'name' => 'Unity Game Development',
                'description' => 'Membangun game 2D dan 3D dengan Unity Engine. Dari basic scripting hingga game mechanics implementation.',
                'expertise' => 'Game Development',
            ],
            [
                'name' => 'C# Programming for Games',
                'description' => 'Bahasa pemrograman C# untuk game development. Object-oriented programming dan Unity-specific patterns.',
                'expertise' => 'Game Development',
            ],
            [
                'name' => 'Game Design Principles',
                'description' => 'Fundamental game design theory. Gameplay mechanics, level design, dan player psychology dalam game development.',
                'expertise' => 'Game Development',
            ],
        ];

        $createdClasses = [];

        foreach ($classesData as $classData) {
            // Find mentor based on expertise
            $expertiseMentors = $mentors->where('expertise', $classData['expertise']);
            
            if ($expertiseMentors->isEmpty()) {
                // If no mentor with specific expertise, use any available mentor
                $mentor = $mentors->random();
            } else {
                $mentor = $expertiseMentors->random();
            }
            
            // Randomly assign some classes to teacher classes if available
            $teacherClass = null;
            if ($teacherClasses->isNotEmpty() && rand(0, 1)) { // 50% chance
                $teacherClass = $teacherClasses->random();
            }

            $class = ClassModel::create([
                'name' => $classData['name'],
                'description' => $classData['description'],
                'mentor_id' => $mentor->id,
                'teacher_class_id' => $teacherClass ? $teacherClass->id : null,
            ]);

            $createdClasses[] = $class;

            // Update mentor's total_students count
            $mentor->increment('total_students', rand(5, 15));
        }

        $this->command->info('✅ Class seeder completed successfully!');
        $this->command->info('📚 ' . count($createdClasses) . ' classes have been created.');
        
        // Show some statistics
        $totalWithTeacherClass = ClassModel::whereNotNull('teacher_class_id')->count();
        $totalLegacy = ClassModel::whereNull('teacher_class_id')->count();
        
        $this->command->info("📊 Classes linked to teacher classes: {$totalWithTeacherClass}");
        $this->command->info("📊 Legacy classes (independent): {$totalLegacy}");
        
        // Show classes per mentor
        $this->command->info('📈 Classes per mentor:');
        foreach ($mentors as $mentor) {
            $classCount = $mentor->classes()->count();
            $this->command->info("   - {$mentor->name}: {$classCount} classes");
        }
    }
}