# Education Platform v2 Overview

## Project Goals
- Menyediakan platform pembelajaran berbasis peran untuk guru, mentor, dan siswa.
- Memfasilitasi alur kurasi kelas oleh guru, implementasi kelas oleh mentor, dan pembelajaran mandiri oleh siswa.
- Menyertakan mekanisme evaluasi (pre-test dan post-test) beserta verifikasi pencapaian berbasis skor minimal 80%.

## Fitur Utama
- **Manajemen Peran**: Otentikasi Laravel Breeze dengan kontrol akses berbasis Spatie Permission (`guru`, `mentor`, `siswa`).
- **Dashboard Berbeda**: Guru diarahkan ke manajemen `TeacherClass`, mentor/siswa ke beranda pembelajaran (`routes/web.php`).
- **Pengelolaan Teacher Class**: Guru membuat mata pelajaran, menyetujui mentor, memantau implementasi kelas dan materi.
- **Kelas Mentor**: Mentor membuat kelas turunan, mengunggah materi, video, dan pre-test yang terhubung dengan TeacherClass.
- **Evaluasi Berlapis**: Pre-test per materi dan post-test per kelas dengan retake terbatas serta permintaan persetujuan mentor.
- **Statistik & Achievement**: Siswa memperoleh badge dan laporan kemajuan jika memenuhi ambang skor.
- **Eksposur Publik**: Listing mata pelajaran dan mentor (route `mata-pelajaran`) untuk eksplorasi tanpa login.

## Tumpukan Teknologi
| Lapisan | Teknologi |
| --- | --- |
| Backend | Laravel 10, PHP 8.1+, Laravel Sanctum, Spatie Permission, Yajra DataTables |
| Frontend | Vite, Tailwind CSS 3, Alpine.js, Axios |
| Build Tools | Composer, NPM/Vite, Laravel Artisan |
| Basis Data | MySQL (diasumsikan melalui konfigurasi Laravel) |

## Struktur Direktori Penting
```
app/
  Http/
    Controllers/        # Logika HTTP untuk dashboard, kelas, quiz, post-test, dll.
    Middleware/         # `CheckRole`, `VerifyMentor`, autentikasi dasar
  Models/               # Entitas domain: TeacherClass, ClassModel, Material, Quiz, dst.
resources/
  views/                # Blade templates untuk layout, dashboard, publik, evaluasi
  js/                   # `app.js`, `navbar.js` (carousel & dropdown)
  css/                  # Tailwind entry + animasi kustom
routes/
  web.php               # Semua route web & middleware
  auth.php              # Scaffold login/registrasi Breeze
```

## Alur Peran Singkat
1. **Guru** membuat `TeacherClass`, memverifikasi mentor lewat `MentorRequest`, dan memonitor implementasi kelas.
2. **Mentor** membuat kelas (`ClassModel`), menambahkan materi dan quiz, serta mengaktifkan post-test.
3. **Siswa** mengikuti materi, mengerjakan pre-test/post-test, dan membuka achievements bila skor >= 80%.

## Dependensi Pihak Ketiga
- **Spatie/laravel-permission**: Manajemen role dan gate berbasis middleware.
- **Yajra/laravel-datatables**: Listing pending mentor di admin view.
- **Sanctum**: API authentication stub (`/user` endpoint) jika perlu pengembangan API lanjut.

Gunakan dokumen lain di folder ini untuk detail backend, frontend, alur data, dan panduan operasional.
