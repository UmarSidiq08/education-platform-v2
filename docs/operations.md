# Operasional & Pengembangan

## 1. Prasyarat
- PHP 8.1+
- Composer 2+
- Node.js 18+ & NPM
- Database MySQL/MariaDB (atau sesuai konfigurasi `.env`)
- Ekstensi PHP standar Laravel (OpenSSL, PDO, Mbstring, dsb.)

## 2. Setup Awal
```bash
cp .env.example .env
php artisan key:generate
composer install
npm install
```

Konfigurasi database pada `.env`, lalu migrasi & seeding:
```bash
php artisan migrate --seed
```
Seeder default menjalankan `RoleSeeder` dan `GuruSeeder`; jalankan `UserSeeder` manual bila ingin data contoh:
```bash
php artisan db:seed --class=UserSeeder
```

## 3. Menjalankan Aplikasi
```bash
php artisan serve
npm run dev  # atau npm run build untuk produksi
```
Gunakan `npm run watch` bila ingin membiarkan Tailwind CLI mengompilasi ke `public/css/app.css`.

## 4. Struktur Role & Login
- **Guru**: Login awal `admin@guru.test` / `password123` (dari `GuruSeeder`).
- **Siswa/Mentor**: Registrasi via form. Mentor wajib memilih TeacherClass dan menunggu persetujuan guru.
- **Redirect**: Guru -> `/admin/dashboard`, mentor/siswa -> `/dashboard`. Mentor belum diverifikasi diarahkan ke `/mentor/waiting`.

## 5. Testing
Gunakan PHPUnit standar:
```bash
php artisan test
```
- Fitur yang tercakup: otentikasi Breeze, profil (`tests/Feature/ProfileTest.php`), dsb.
- Tambahkan pengujian untuk quiz/post-test saat menambah fitur baru.

## 6. Storage & Media
- Jalankan `php artisan storage:link` untuk memastikan upload video/avatar dapat diakses publik.
- Materi video disimpan di `storage/app/public/materials/...` dan diakses melalui `asset('storage/...')`.

## 7. Logging & Debug
- Laravel default logging (file `storage/logs/laravel.log`).
- Controller kunci menulis log info/error (misal quiz auto submit). Gunakan `tail -f storage/logs/laravel.log` saat debug real-time.

## 8. Pemeliharaan
- Pastikan dependency sinkron (`composer outdated`, `npm outdated`).
- Audit route yang merujuk controller tidak tersedia (mis. `NavbarMentorController`).
- Evaluasi refactor controller kompleks ke service class bila menambah fitur lanjutan.

## 9. Rencana Pengembangan
- Dokumentasikan modul baru langsung di folder `docs/` ini.
- Tambahkan diagram visual (PlantUML/Mermaid) bila diperlukan untuk alur kompleks.
- Siapkan pipeline CI nanti dengan langkah: install deps -> migrate -> test -> build Vite.
