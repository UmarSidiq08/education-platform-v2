# Frontend Architecture

## Layout & Struktur
- **Layout utama**: `resources/views/layouts/app.blade.php` menyertakan navbar, footer, dan memanggil bundle Vite (`@vite`).
- **Komponen Navbar**: `resources/views/layout/template.blade.php` berisi markup navbar, carousel, dan styling inline untuk efek gradien dan glassmorphism.
- **Footer & Bagian lain**: Didefinisikan dalam `resources/views/layout` serta partial Blade untuk navbar khusus (`resources/views/navbar`).
- **Halaman utama**: `resources/views/welcome.blade.php` me-render carousel dan partial layout.

## Styling
- **Tailwind CSS** sebagai fondasi (lihat `resources/css/app.css`), ditambah beberapa keyframe animasi (`fadeIn`, `slideIn`, `fadeSlideUp`).
- Inline CSS pada beberapa view (contoh `classes/index.blade.php`) memberi efek khusus. Disarankan refactor ke utilitas Tailwind bila ingin konsistensi.
- Konfigurasi Tailwind di `tailwind.config.js` dengan plugin forms & typography (`package.json`).

## JavaScript
- **Entry**: `resources/js/app.js` mem-boot Alpine.js.
- **Bootstrap**: `resources/js/bootstrap.js` menyiapkan axios (header `X-Requested-With`) dan placeholder untuk Echo/Pusher.
- **Navbar & Carousel**: `resources/js/navbar.js`
  - Kelas `EnhancedCarousel` dengan autoplay, swipe, keyboard navigation, progress bar.
  - Dropdown user dengan klik luar untuk menutup, confirm logout placeholder.
  - Smooth-scrolling anchor.
- Bundle dijalankan via Vite (`vite.config.js`) dan dihidupkan dengan npm `dev`/`build`.

## Blade Views
- **Dashboard & Profil**: `resources/views/user`, `resources/views/profile`, `resources/views/mentor`, `resources/views/admin`.
- **Kelas & Materi**: `resources/views/classes`, `resources/views/materials`, `resources/views/quizzes`, `resources/views/post_tests`.
- **Publik**: `resources/views/public/teacher-classes` menyediakan halaman index, filter, detail mentor.
- **Komponen**: `resources/views/components` untuk partial kecil (cek isi sebelum reuse).

## Asset Pipeline
1. Jalankan `npm install` untuk dependensi front-end.
2. Gunakan `npm run dev` saat pengembangan (Vite HMR) atau `npm run build` untuk produksi.
3. Tailwind watch terpisah tersedia (`npm run watch`) untuk menghasilkan `public/css/app.css` jika tidak memakai Vite secara penuh.

## Pengelolaan Media
- Upload video/thumbnail materi tersimpan di storage publik (lihat `MaterialController`), diakses via `asset('storage/...')`.
- Avatar profil juga dilewatkan ke storage publik melalui `ProfileController`.

## Rekomendasi
- Pertimbangkan break down CSS inline ke file khusus atau Tailwind component class.
- Tambahkan komponen Livewire/Inertia jika membutuhkan interaktivitas lanjutan.
- Pastikan `NavbarMentorController` yang hilang tidak dirujuk oleh view agar layout tetap stabil.
