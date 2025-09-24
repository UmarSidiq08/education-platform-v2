# Backend Architecture

## Controllers
### Dashboard & Profil
- `DashboardController` (`app/Http/Controllers/DashboardController.php`): Menampilkan beranda umum bagi mentor/siswa (view `welcome`).
- `AdminDashboardController` (`app/Http/Controllers/AdminDashboardController.php`): Rekap jumlah user per role untuk guru.
- `ProfileController` (`app/Http/Controllers/ProfileController.php`): Menangani edit profil, upload avatar, log aktivitas `Activity`.

### Kelas & Materi
- `TeacherClassController`: CRUD `TeacherClass`, nested resource untuk mentor class dan materi, API dropdown registrasi, implementasi guru (`app/Http/Controllers/TeacherClassController.php`).
- `MentorRequestController`: Kelola permintaan mentor (approve/reject), sinkronisasi role mentor/siswa (`app/Http/Controllers/MentorRequestController.php`).
- `ClassController`: CRUD kelas mentor, halaman belajar dengan perhitungan progres >=80% (`app/Http/Controllers/ClassController.php`).
- `MaterialController`: Buat/edit/hapus materi, unggah video & thumbnail, cek kepemilikan mentor (`app/Http/Controllers/MaterialController.php`).

### Evaluasi
- `QuizController`: Lifecycle pre-test (multi-attempt, timer, auto-submit, result view). Menggunakan transaksi DB untuk penyimpanan progres (`app/Http/Controllers/QuizController.php`).
- `PostTestController`: Mirip quiz namun untuk level kelas, menegakkan urutan pre-test -> post-test, approval attempt ke-3 dst (`app/Http/Controllers/PostTestController.php`).
- `AchievementController`: Kumpulkan kelas yang lulus (>=80%), statistik, badge (`app/Http/Controllers/AchievementController.php`).

### Publik & Mentor
- `MentorController`: Listing mentor (DataTables untuk pending list) + verifikasi admin (`app/Http/Controllers/MentorController.php`).
- `PublicTeacherClassController`: Halaman publik mata pelajaran, pencarian AJAX dengan prioritas, listing mentor per subject (`app/Http/Controllers/PublicTeacherClassController.php`).
- `LoginController`: Override redirect pasca login berdasarkan role (`app/Http/Controllers/LoginController.php`).
- `Auth/RegisteredUserController`: Registrasi multi-role, auto request mentor (`app/Http/Controllers/Auth/RegisteredUserController.php`).

> Catatan: `CourseController` referensi ke model `Course` yang belum ada; evaluasi apakah legacy dan bisa dihapus atau perlu implementasi lanjutan.

## Models & Relasi
- `User`: Memakai `HasRoles`, relasi ke `Activity`, `ClassModel`, `QuizAttempt`, `TeacherClass`, `MentorRequest`. Menyediakan helper progress, stats, achievements (`app/Models/User.php`).
- `TeacherClass`: Dimiliki guru, relasi ke `MentorRequest`, mentor approved, implementation classes (`app/Models/TeacherClass.php`).
- `MentorRequest`: Status `pending/approved/rejected`, helper approve/reject, badge color/text (`app/Models/MentorRequest.php`).
- `ClassModel`: Kelas mentor, relasi ke `User`, `TeacherClass`, `Material`, `PostTest`, accessor `full_name`, helper achievements (`app/Models/ClassModel.php`).
- `Material`: Materi kelas, relasi ke `ClassModel` dan `Quiz`, helper video embed/thumbnail (`app/Models/Material.php`).
- `Quiz` & `QuizAttempt`: Pre-test, multi-attempt, best attempt, status badge, persistent timer (`app/Models/Quiz.php`, `app/Models/QuizAttempt.php`).
- `PostTest`, `PostTestQuestion`, `PostTestAttempt`: Struktur post-test, approval dan scoring, persentase, badge level (`app/Models/PostTest*.php`).
- `Question`: Pertanyaan quiz dengan opsi array (`app/Models/Question.php`).
- `Activity`: Log kronologis aksi user untuk halaman profil (`app/Models/Activity.php`).

## Middleware & Kernel
- `CheckRole`: Validasi role sederhana via string comparation (`app/Http/Middleware/CheckRole.php`).
- `VerifyMentor`: Mengarahkan mentor belum diverifikasi ke `mentor.waiting` (`app/Http/Middleware/VerifyMentor.php`).
- Kernel alias `role` dan `verify.mentor` digunakan di grup route (lihat `app/Http/Kernel.php`).

## Routing
- Seluruh route web di `routes/web.php` termasuk dashboard per role, kelas, materi, quiz, post-test, achievements, teacher class, API kecil (check name, dropdown teacher class).
- `routes/auth.php` mempertahankan default Breeze untuk registrasi/login/reset password.
- Periksa referensi `NavbarMentorController` yang tidak ada (baris 16) untuk menghindari autoload error saat route diakses.

## Layanan & Provider
- `AppServiceProvider` mengatur locale Carbon ke Bahasa Indonesia (`app/Providers/AppServiceProvider.php`).
- Provider lain mengikuti default Laravel (Auth/Broadcast/Event/Route) tanpa kustomisasi.

## Database & Seeder
- Migrasi meliputi `classes`, `materials`, `quizzes`, `quiz_attempts`, `post_tests`, `teacher_classes`, `mentor_requests`, serta kolom tambahan (video, timer, dsb.) (`database/migrations/`).
- Seeder:
  - `RoleSeeder`: Membuat role `guru`, `mentor`, `siswa`.
  - `GuruSeeder`: Membuat akun guru default dan assign role.
  - `UserSeeder`: Contoh user + aktivitas.
- Gunakan `DatabaseSeeder` untuk menjalankan seeder inti (`database/seeders/DatabaseSeeder.php`).

## Error Handling & Logging
- Berbagai controller melakukan logging via `Log::info` atau `Log::error` saat operasi penting (quiz auto submit, mentor approvals).
- Validasi request memanfaatkan `abort(403)` untuk unauthorized access, serta `findOrFail` untuk resource retrieval.

## Area untuk Ditindaklanjuti
- Susun service layer atau FormRequest khusus untuk controller kompleks (Quiz/PostTest) demi maintainability.
- Pertimbangkan caching untuk listing publik atau rekap admin jika volume data besar.
- Tambahkan policy/authorization object bila alur akses bertambah kompleks.
