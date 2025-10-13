# Data & Feature Flow

## 1. Registrasi & Role Assignment
1. User mengisi form registrasi (`Auth/RegisteredUserController@store`).
2. Role ditentukan (`siswa`, `mentor`, `guru`), `is_verified` auto true kecuali mentor.
3. Jika role `mentor`, sistem otomatis membuat `MentorRequest` berstatus `pending` dan mewajibkan pemilihan `TeacherClass`.
4. Setelah login, `LoginController@authenticated` mengarahkan guru ke `/admin/dashboard`, role lain ke `/dashboard`.
5. Middleware `verify.mentor` memastikan mentor belum diverifikasi diarahkan ke halaman waiting.

## 2. Kurasi Teacher Class (Guru)
1. Guru membuat mata pelajaran di `TeacherClassController@store`.
2. Mentor mengirim permintaan melalui `MentorRequestController@store`.
3. Guru melihat pending request (`MentorRequestController@pendingRequests`) dan dapat `approve` atau `reject`:
   - Approve: Mentor menjadi `is_verified = true`, masuk daftar approved.
   - Reject: Mentor diubah ke role `siswa` dan status request `rejected`.
4. Guru memantau implementasi kelas mentor dan materi via nested route `teacher-classes/{teacherClass}/classes/{class}`.

## 3. Implementasi Kelas (Mentor)
1. Mentor yang sudah disetujui dapat membuat kelas (`ClassController@store`) dengan relasi opsional ke `TeacherClass`.
2. Materi ditambahkan melalui `MaterialController@store`, memiliki konten, video optional, dan quiz.
3. Untuk setiap materi, mentor membuat pre-test (`QuizController@store`) dan memilih mana yang aktif.
4. Mentor menambahkan post-test di level kelas (`PostTestController@store`) dan dapat menduplikasi atau mengaktifkan ulang.

## 4. Pembelajaran Siswa
1. Siswa membuka kelas via `/classes/{id}/learn`.
2. Controller menghitung progres dengan iterasi materi dan best quiz attempt (`>=80%`).
3. Materi dapat berisi video (file/url) dan quiz aktif. Siswa menjalankan quiz dengan sistem multi-attempt dan timer:
   - `QuizController@start` membuat attempt baru.
   - `saveProgress/updateTimer` menyimpan jawaban/timer.
   - `submit/autoSubmit` menghitung skor dan menutup attempt.
4. Setelah semua pre-test aktif lulus, siswa bisa membuka post-test (`PostTestController@show`).

## 5. Post-Test & Approval Retake
1. Attempt 1-2 post-test tersedia tanpa approval.
2. Jika skor <80% setelah 2 attempt, siswa harus `requestApproval`:
   - Membuat `PostTestAttempt` dummy `requires_approval = true`.
3. Mentor melihat daftar approval (`PostTestController@approvalRequests`) dan dapat menyetujui.
4. Persetujuan menandai `is_used = false` hingga siswa memulai attempt baru (then flagged `is_used = true`).
5. Auto submit dan timer bekerja mirip quiz (endpoint `saveProgress`, `updateTimer`).

## 6. Achievements & Statistik
1. `AchievementController@index` memanggil helper di model `User` untuk mengumpulkan kelas dengan post-test aktif yang lulus (>=80%).
2. Data yang dihitung termasuk total kelas selesai, skor rata-rata, badge (perfect, excellent, good).
3. Halaman detail (`achievements/{class}`) menampilkan attempt histori dan best attempt.

## 7. Listing Publik
1. Route `mata-pelajaran` (`PublicTeacherClassController@index`) memuat TeacherClass beserta jumlah mentor.
2. Endpoint `search` menggunakan pencarian dengan prioritas nama/subject/guru + AJAX response HTML.
3. `show` menampilkan detail guru dan mentor, `mentor-classes` menampilkan kelas mentor dan jumlah materi.

## 8. API & Integrasi Ringan
- `/api/check-name` memastikan nama unik saat registrasi.
- `/api/teacher-classes` mengirim JSON untuk dropdown registrasi mentor.
- Endpoint API lain dapat dibuat memakai Sanctum (stub `/user`).

## Diagram Teks
```
Guru -> TeacherClass -> MentorRequest (approve) -> Mentor -> ClassModel -> Material -> Quiz
                                                \-> PostTest -> PostTestAttempt -> Achievement
Siswa -> Materi (Quiz) -> Progress 80% -> PostTest -> Achievement
```

Gunakan dokumen backend/frontend untuk detail implementasi kode.
