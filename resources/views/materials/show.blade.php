@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 xl:grid-cols-[1fr_350px] gap-8">
            <!-- Main Content -->
            <div class="min-w-0 break-words">
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl mb-8 break-words">
                    <!-- Header -->
                    <div
                        class="p-10 border-b border-gray-200 bg-gradient-to-br from-indigo-500 to-purple-600 text-white relative overflow-hidden">
                        <nav aria-label="breadcrumb">
                            <ol class="flex items-center space-x-2 mb-6">
                                <li>
                                    <a href="{{ route('classes.learn', $material->class->id) }}"
                                        class="flex items-center text-white/80 hover:text-white transition-colors duration-300 font-medium">
                                        <i class="fas fa-arrow-left mr-2"></i>{{ $material->class->name }}
                                    </a>
                                </li>
                                <li class="text-white/90">{{ $material->title }}</li>
                            </ol>
                        </nav>

                        <h1 class="text-4xl font-bold mb-6 leading-tight">{{ $material->title }}</h1>

                        <div class="flex flex-wrap items-center gap-8 mb-6">
                            <span class="flex items-center text-white/90 bg-white/10 px-4 py-2 rounded-full backdrop-blur">
                                <i class="fas fa-calendar text-white/80 mr-2"></i>
                                {{ $material->created_at->format('d M Y') }}
                            </span>
                            <span class="flex items-center text-white/90 bg-white/10 px-4 py-2 rounded-full backdrop-blur">
                                <i class="fas fa-user text-white/80 mr-2"></i>
                                {{ $material->class->mentor->name }}
                            </span>
                            @if ($material->is_published)
                                <span
                                    class="inline-flex items-center bg-green-500 text-white px-4 py-2 rounded-full font-semibold text-sm">
                                    <i class="fas fa-check-circle mr-2"></i>Published
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center bg-yellow-500 text-white px-4 py-2 rounded-full font-semibold text-sm">
                                    <i class="fas fa-clock mr-2"></i>Draft
                                </span>
                            @endif
                        </div>

                        @if ($material->description)
                            <div class="bg-white/15 p-6 rounded-xl border border-white/20 backdrop-blur">
                                <p class="text-white/95 leading-relaxed">{{ $material->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Video Section -->
                    @if ($material->hasVideo())
                        <div class="p-10 bg-black">
                            <div class="max-w-full mx-auto rounded-2xl overflow-hidden shadow-2xl">
                                @if ($material->getVideoType() === 'file')
                                    {{-- Video dari Storage --}}
                                    <video controls poster="{{ $material->video_thumbnail_url }}"
                                        class="w-full aspect-video rounded-2xl">
                                        <source src="{{ $material->video_url_for_display }}" type="video/mp4">
                                        Browser tidak mendukung pemutaran video.
                                    </video>
                                @elseif($material->isVideoEmbeddable())
                                    {{-- Video YouTube/Vimeo Embeddable --}}
                                    <div id="video-container-{{ $material->id }}"
                                        class="relative w-full aspect-video bg-cover bg-center cursor-pointer rounded-2xl overflow-hidden"
                                        style="background-image: url('{{ $material->video_thumbnail_url }}')"
                                        data-video-url="{{ $material->video_url }}">
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                                            <div
                                                class="text-8xl text-white/90 transition-all duration-300 hover:text-white hover:scale-110 drop-shadow-2xl">
                                                <i class="fas fa-play-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Video External Link --}}
                                    <div
                                        class="aspect-video flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-center p-12 rounded-2xl">
                                        <div>
                                            <i class="fas fa-play-circle text-6xl mb-6"></i>
                                            <h4 class="text-2xl font-bold mb-4">Video Eksternal</h4>
                                            <p class="text-white/80 mb-8 text-lg">Klik untuk menonton video di platform eksternal
                                            </p>
                                            <a href="{{ $material->video_url }}" target="_blank"
                                                class="inline-flex items-center bg-white text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-colors duration-300">
                                                <i class="fas fa-external-link-alt mr-3"></i>Tonton Video
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Content Section -->
                    <div class="p-10 break-words">
                        <h5 class="flex items-center text-xl font-semibold text-gray-600 mb-8">
                            <i class="fas fa-file-text text-indigo-500 mr-3"></i>Materi Pembelajaran
                        </h5>
                        <div class="prose prose-lg max-w-none break-words text-gray-600 leading-relaxed">
                            {!! $material->content !!}
                        </div>
                    </div>
                </div>

                <!-- Enhanced Quiz Section -->
                @if ($material->activeQuiz)
                    <div class="mt-8 mb-16">
                        <div
                            class="bg-white rounded-3xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl border-2 border-transparent hover:border-indigo-500">
                            <div
                                class="bg-gradient-to-br from-indigo-500 to-purple-600 p-8 text-white flex items-center gap-6 relative overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full transform translate-x-1/2 -translate-y-1/2">
                                </div>

                                <div
                                    class="bg-white/20 w-20 h-20 rounded-3xl flex items-center justify-center text-3xl backdrop-blur border-2 border-white/30 shrink-0 relative z-10">
                                    <i class="fas fa-brain"></i>
                                </div>

                                <div class="flex-1 relative z-10">
                                    <h3 class="text-2xl font-bold mb-2">{{ $material->activeQuiz->title }}</h3>
                                    @if ($material->activeQuiz->description)
                                        <p class="text-white/90 text-lg">{{ $material->activeQuiz->description }}</p>
                                    @endif
                                </div>

                                {{-- Tampilkan skor untuk siswa dan mentor yang sudah mengerjakan --}}
                                @if (
                                        (auth()->user()->role === 'siswa' ||
                                            (auth()->user()->role === 'mentor' && auth()->id() !== $material->class->mentor_id)) &&
                                        $quizAttempt
                                    )
                                        <div class="relative z-10">
                                            <div
                                                class="bg-white/20 w-20 h-20 rounded-full flex flex-col items-center justify-center backdrop-blur border-3 border-white/30">
                                                <span
                                                    class="text-xl font-black leading-none">{{ $quizAttempt->percentage }}%</span>
                                                <span class="text-xs opacity-90 uppercase font-semibold">Skor</span>
                                            </div>
                                        </div>
                                @endif
                            </div>

                            <div class="p-10">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                    <div
                                        class="flex items-center gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-100 transition-all duration-300 hover:bg-gray-100 hover:-translate-y-1">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-xl">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">
                                                {{ $material->activeQuiz->total_questions }}</div>
                                            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Soal
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-100 transition-all duration-300 hover:bg-gray-100 hover:-translate-y-1">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-xl">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">
                                                {{ $material->activeQuiz->time_limit }}</div>
                                            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Menit
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-100 transition-all duration-300 hover:bg-gray-100 hover:-translate-y-1">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-xl">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">
                                                {{ $material->activeQuiz->questions->sum('points') ?? 0 }}</div>
                                            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Poin
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section untuk siswa dan mentor non-pemilik yang dapat mengerjakan quiz --}}
                                @if (
                                        auth()->user()->role === 'siswa' ||
                                        (auth()->user()->role === 'mentor' && auth()->id() !== $material->class->mentor_id)
                                    )
                                        @if ($quizAttempt)
                                            <!-- Sudah mengerjakan - Detail Results dengan info multiple attempts -->
                                            <div
                                                class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 border border-gray-200">
                                                <div class="mb-6">
                                                    <h5 class="flex items-center text-xl font-semibold text-gray-600">
                                                        <i class="fas fa-chart-line mr-3"></i>Hasil Pre Test Terbaik Anda
                                                    </h5>
                                                    @if ($material->activeQuiz->getTotalAttemptsByUser(auth()->id()) > 1)
                                                        <p class="text-sm text-gray-500 mt-1">
                                                            Dari
                                                            {{ $material->activeQuiz->getTotalAttemptsByUser(auth()->id()) }}
                                                            percobaan
                                                            <span
                                                                class="inline-flex items-center ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                                                <i class="fas fa-crown mr-1"></i> SKOR TERTINGGI
                                                            </span>
                                                        </p>
                                                    @endif
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                                                    <div
                                                        class="bg-white p-6 rounded-xl flex items-center gap-4 shadow-lg border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                                        <div
                                                            class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 text-white flex items-center justify-center text-xl">
                                                            <i class="fas fa-trophy"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-xl font-bold text-gray-900">
                                                                {{ $quizAttempt->score }}</div>
                                                            <div class="text-gray-500 text-sm font-medium">Total Poin</div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="bg-white p-6 rounded-xl flex items-center gap-4 shadow-lg border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                                        <div
                                                            class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center text-xl">
                                                            <i class="fas fa-check-circle"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-xl font-bold text-gray-900">
                                                                {{ $quizAttempt->correct_answers }}/{{ $quizAttempt->total_questions }}
                                                            </div>
                                                            <div class="text-gray-500 text-sm font-medium">Jawaban Benar</div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="bg-white p-6 rounded-xl flex items-center gap-4 shadow-lg border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                                        <div
                                                            class="w-12 h-12 rounded-full bg-gradient-to-br {{ $quizAttempt->percentage >= 80 ? 'from-green-400 to-green-600' : ($quizAttempt->percentage >= 60 ? 'from-yellow-400 to-yellow-600' : 'from-red-400 to-red-600') }} text-white flex items-center justify-center text-xl">
                                                            <i class="fas fa-percent"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-xl font-bold text-gray-900">
                                                                {{ $quizAttempt->percentage }}%</div>
                                                            <div class="text-gray-500 text-sm font-medium">Persentase</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex justify-center gap-4 flex-wrap">
                                                    <a href="{{ route('quizzes.show', $material->activeQuiz) }}"
                                                        class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-indigo-500 text-indigo-500 rounded-xl font-semibold text-lg transition-all duration-300 hover:bg-indigo-500 hover:text-white hover:-translate-y-1 hover:shadow-lg">
                                                        <i class="fas fa-eye mr-3"></i>Lihat Detail & Riwayat
                                                    </a>

                                                    <form action="{{ route('quizzes.start', $material->activeQuiz) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                                            <i class="fas fa-redo mr-2"></i> Coba Lagi
                                                        </button>
                                                    </form>
                                                </div>

                                                @if ($quizAttempt->percentage < 70)
                                                    <div class="mt-6 p-4 bg-orange-50 border border-orange-200 rounded-xl">
                                                        <div class="flex items-center text-orange-800">
                                                            <i class="fas fa-lightbulb mr-2"></i>
                                                            <span class="font-semibold">Tips:</span>
                                                        </div>
                                                        <p class="text-orange-700 mt-1">Nilai Anda masih bisa ditingkatkan!
                                                            Pelajari kembali materi dan coba Pre Test lagi untuk mendapatkan
                                                            skor
                                                            yang lebih baik.</p>
                                                    </div>
                                                @elseif($quizAttempt->percentage >= 90)
                                                    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                                                        <div class="flex items-center text-green-800">
                                                            <i class="fas fa-star mr-2"></i>
                                                            <span class="font-semibold">Excellent!</span>
                                                        </div>
                                                        <p class="text-green-700 mt-1">Nilai Anda sangat baik! Anda dapat
                                                            mencoba lagi untuk mempertahankan atau meningkatkan skor ini.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <!-- Belum mengerjakan - Call to Action -->
                                            <div
                                                class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-10 rounded-2xl text-center relative overflow-hidden">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse">
                                                </div>
                                                <div class="relative z-10 mb-8">
                                                    <h5 class="text-2xl font-bold mb-2">Siap untuk mengerjakan Pre Test?</h5>
                                                    <p class="text-white/90 text-lg">Uji pemahaman Anda tentang materi yang
                                                        telah dipelajari</p>
                                                    <p class="text-white/75 text-sm mt-2">* Anda dapat mengerjakan Pre Test
                                                        berulang kali, skor tertinggi akan menjadi nilai akhir</p>
                                                </div>
                                                <div class="relative z-10">
                                                    <form action="{{ route('quizzes.start', $material->activeQuiz) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="inline-flex items-center px-10 py-4 bg-white text-indigo-600 rounded-xl font-bold text-lg transition-all duration-300 hover:bg-gray-100 hover:-translate-y-1 hover:shadow-2xl animate-pulse">
                                                            <i class="fas fa-play mr-3"></i> Mulai Pre Test Sekarang
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                @endif

                                {{-- Section khusus untuk mentor pemilik kelas (CRUD dan statistik) --}}
                                @if (auth()->user()->role === 'mentor' && auth()->id() === $material->class->mentor_id)
                                    <!-- Mentor Actions -->
                                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100">
                                        <div class="mb-6">
                                            <h5 class="flex items-center text-xl font-semibold text-gray-600 mb-2">
                                                <i class="fas fa-cogs mr-3"></i>Kelola Pre Test
                                            </h5>
                                            <p class="text-gray-500">Kelola dan pantau Pre Test untuk materi ini</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <a href="{{ route('quizzes.index', $material) }}"
                                                class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl font-semibold text-center min-h-[120px] transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                                                <i class="fas fa-chart-bar text-2xl mb-2"></i>
                                                <span class="font-semibold mb-1">Lihat Statistik</span>
                                                <small class="text-blue-100 text-sm">Analisis hasil siswa</small>
                                            </a>
                                            <a href="{{ route('quizzes.edit', [$material, $material->activeQuiz]) }}"
                                                class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-xl font-semibold text-center min-h-[120px] transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                                                <i class="fas fa-edit text-2xl mb-2"></i>
                                                <span class="font-semibold mb-1">Edit Pre Test</span>
                                                <small class="text-yellow-100 text-sm">Ubah soal & pengaturan</small>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif(auth()->user()->role === 'mentor' && auth()->id() === $material->class->mentor_id)
                        <!-- No Quiz - Create New (hanya untuk mentor pemilik kelas) -->
                        <div class="mt-8 mb-16">
                            <div
                                class="bg-white rounded-3xl p-12 text-center shadow-2xl border-2 border-dashed border-gray-200 transition-all duration-300 hover:border-indigo-500 hover:shadow-3xl">
                                <div
                                    class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-5xl text-white shadow-2xl">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <h4 class="text-gray-900 font-bold mb-4 text-2xl">Tingkatkan Pembelajaran dengan Pre Test</h4>
                                <p class="text-gray-500 text-lg leading-relaxed mb-8">Buat Pre Test interaktif untuk membantu
                                    siswa
                                    menguji pemahaman mereka tentang materi ini</p>
                                <div class="flex justify-center gap-8 mb-10 flex-wrap">
                                    <div class="flex items-center text-gray-600 font-medium">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Pertanyaan pilihan ganda</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 font-medium">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Penilaian otomatis</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 font-medium">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Laporan detail</span>
                                    </div>
                                </div>
                                <a href="{{ route('quizzes.create', $material) }}"
                                    class="inline-flex items-center px-12 py-5 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl font-bold text-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl relative overflow-hidden group">
                                    <span
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-600"></span>
                                    <i class="fas fa-plus mr-3 relative z-10"></i>
                                    <span class="relative z-10">Buat Pre Test Pertama</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="min-w-0 mb-16">
                    <div class="sticky top-8 max-h-[calc(100vh-4rem)] overflow-y-auto space-y-6">
                        <!-- Class Info -->
                        <div
                            class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-b border-gray-200 px-6 py-5">
                                <h6 class="flex items-center font-semibold text-gray-600">
                                    <i class="fas fa-graduation-cap mr-3"></i>Informasi Kelas
                                </h6>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-15 h-15 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg mr-4 shadow-xl">
                                        {{ substr($material->class->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h6 class="text-gray-900 font-semibold mb-1">{{ $material->class->name }}</h6>
                                        <small class="text-gray-500">Mentor: {{ $material->class->mentor->name }}</small>
                                    </div>
                                </div>
                                @if ($material->class->description)
                                    <p class="text-gray-500 text-sm leading-relaxed">{{ $material->class->description }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Material Details -->
                        <div
                            class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-b border-gray-200 px-6 py-5">
                                <h6 class="flex items-center font-semibold text-gray-600">
                                    <i class="fas fa-info-circle mr-3"></i>Detail Materi
                                </h6>
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                                    <span class="font-semibold text-gray-500 text-sm">Status:</span>
                                    <span>
                                        @if ($material->is_published)
                                            <span
                                                class="inline-flex items-center bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Published</span>
                                        @else
                                            <span
                                                class="inline-flex items-center bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                                        @endif
                                    </span>
                                </div>

                                <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                                    <span class="font-semibold text-gray-500 text-sm">Dibuat:</span>
                                    <span
                                        class="text-gray-600 text-sm font-medium">{{ $material->created_at->format('d M Y, H:i') }}</span>
                                </div>

                                @if ($material->updated_at != $material->created_at)
                                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                                        <span class="font-semibold text-gray-500 text-sm">Diperbarui:</span>
                                        <span
                                            class="text-gray-600 text-sm font-medium">{{ $material->updated_at->format('d M Y, H:i') }}</span>
                                    </div>
                                @endif

                                @if ($material->hasVideo())
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold text-gray-500 text-sm">Media:</span>
                                        <span class="flex items-center text-gray-600 text-sm font-medium">
                                            <i class="fas fa-video text-indigo-500 mr-2"></i>
                                            {{ $material->getVideoType() === 'file' ? 'Video File' : 'Video Online' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Mentor Actions -->
                        @if (auth()->id() === $material->class->mentor_id)
                            <div
                                class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-b border-gray-200 px-6 py-5">
                                    <h6 class="flex items-center font-semibold text-gray-600">
                                        <i class="fas fa-cogs mr-3"></i>Aksi Mentor
                                    </h6>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-3">
                                        <a href="{{ route('materials.edit', $material) }}"
                                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl font-semibold transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                                            <i class="fas fa-edit mr-3"></i>Edit Materi
                                        </a>

                                        <form action="{{ route('materials.destroy', $material) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-br from-red-500 to-red-600 text-white rounded-xl font-semibold transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                                                <i class="fas fa-trash mr-3"></i>Hapus Materi
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                // Function untuk konversi URL YouTube ke format embed
                function getYouTubeEmbedUrl(url) {
                    let videoId = null;

                    // Format: https://www.youtube.com/watch?v=VIDEO_ID
                    if (url.includes('youtube.com/watch')) {
                        const urlParams = new URLSearchParams(new URL(url).search);
                        videoId = urlParams.get('v');
                    }
                    // Format: https://youtu.be/VIDEO_ID
                    else if (url.includes('youtu.be/')) {
                        videoId = url.split('youtu.be/')[1].split('?')[0].split('&')[0];
                    }
                    // Format: https://www.youtube.com/embed/VIDEO_ID
                    else if (url.includes('youtube.com/embed/')) {
                        videoId = url.split('embed/')[1].split('?')[0].split('&')[0];
                    }

                    if (videoId) {
                        return `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
                    }

                    return url;
                }

                // Function untuk konversi URL Vimeo ke format embed
                function getVimeoEmbedUrl(url) {
                    let videoId = null;

                    // Format: https://vimeo.com/VIDEO_ID
                    if (url.includes('vimeo.com/')) {
                        videoId = url.split('vimeo.com/')[1].split('?')[0].split('/')[0];
                    }

                    if (videoId) {
                        return `https://player.vimeo.com/video/${videoId}?autoplay=1`;
                    }

                    return url;
                }

                // Initialize video players
                document.addEventListener('DOMContentLoaded', function() {
                    const videoContainers = document.querySelectorAll('[id^="video-container-"]');

                    videoContainers.forEach(container => {
                        container.addEventListener('click', function() {
                            const videoUrl = this.getAttribute('data-video-url');
                            let embedUrl = videoUrl;

                            // Deteksi platform dan konversi URL
                            if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                                embedUrl = getYouTubeEmbedUrl(videoUrl);
                            } else if (videoUrl.includes('vimeo.com')) {
                                embedUrl = getVimeoEmbedUrl(videoUrl);
                            }

                            // Buat iframe element
                            const iframe = document.createElement('iframe');
                            iframe.src = embedUrl;
                            iframe.frameBorder = '0';
                            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
                            iframe.allowFullscreen = true;
                            iframe.className = 'w-full aspect-video rounded-2xl';

                            // Replace container dengan iframe
                            this.innerHTML = '';
                            this.appendChild(iframe);
                            this.classList.remove('cursor-pointer', 'bg-cover', 'bg-center');
                            this.style.backgroundImage = 'none';
                        });
                    });

                    // Smooth scroll untuk breadcrumb navigation
                    const breadcrumbLinks = document.querySelectorAll('nav a');
                    breadcrumbLinks.forEach(link => {
                        link.addEventListener('click', function(e) {
                            if (this.getAttribute('href').startsWith('#')) {
                                e.preventDefault();
                                const target = document.querySelector(this.getAttribute('href'));
                                if (target) {
                                    target.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });
                                }
                            }
                        });
                    });

                    // Enhanced button interactions
                    const buttons = document.querySelectorAll('a[class*="bg-"], button[class*="bg-"]');
                    buttons.forEach(button => {
                        button.addEventListener('mouseenter', function() {
                            if (!this.classList.contains('hover:scale-105')) {
                                this.style.transform = 'translateY(-2px)';
                            }
                        });

                        button.addEventListener('mouseleave', function() {
                            if (!this.classList.contains('hover:scale-105')) {
                                this.style.transform = 'translateY(0)';
                            }
                        });

                        button.addEventListener('mousedown', function() {
                            this.style.transform = 'translateY(0) scale(0.98)';
                        });

                        button.addEventListener('mouseup', function() {
                            this.style.transform = 'translateY(-2px) scale(1)';
                        });
                    });

                    // Progress animation for quiz results
                    const resultCards = document.querySelectorAll('.bg-white.p-6.rounded-xl');
                    resultCards.forEach((card, index) => {
                        card.style.animationDelay = `${index * 0.1}s`;
                        card.classList.add('animate-fadeIn');
                    });

                    // Add custom CSS for animations and prose styles
                    const style = document.createElement('style');
                    style.textContent = `
                        @keyframes fadeIn {
                            from {
                                opacity: 0;
                                transform: translateY(20px);
                            }
                            to {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }

                        .animate-fadeIn {
                            animation: fadeIn 0.6s ease-out forwards;
                        }

                        /* Custom prose styles for rich content */
                        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
                            color: #374151 !important;
                            font-weight: 700 !important;
                            margin-top: 2rem !important;
                            margin-bottom: 1rem !important;
                        }

                        .prose h1 { font-size: 2.5rem !important; }
                        .prose h2 { font-size: 2rem !important; }
                        .prose h3 { font-size: 1.75rem !important; }
                        .prose h4 { font-size: 1.5rem !important; }
                        .prose h5 { font-size: 1.25rem !important; }
                        .prose h6 { font-size: 1.1rem !important; }

                        .prose p {
                            margin-bottom: 1.5rem !important;
                            word-wrap: break-word !important;
                            overflow-wrap: break-word !important;
                            line-height: 1.8 !important;
                            color: #6B7280 !important;
                        }

                        .prose strong, .prose b {
                            font-weight: 700 !important;
                            color: #374151 !important;
                        }

                        .prose em, .prose i {
                            font-style: italic !important;
                        }

                        .prose u {
                            text-decoration: underline !important;
                        }

                        .prose s, .prose strike {
                            text-decoration: line-through !important;
                        }

                        .prose mark {
                            background-color: #FEF3C7 !important;
                            padding: 0.2em 0.4em !important;
                            border-radius: 0.375rem !important;
                        }

                        .prose ul, .prose ol {
                            margin-bottom: 1.5rem !important;
                            padding-left: 2rem !important;
                        }

                        .prose ul li, .prose ol li {
                            margin-bottom: 0.5rem !important;
                            line-height: 1.6 !important;
                        }

                        .prose ul {
                            list-style-type: disc !important;
                        }

                        .prose ol {
                            list-style-type: decimal !important;
                        }

                        .prose a {
                            color: #6366F1 !important;
                            text-decoration: none !important;
                            font-weight: 500 !important;
                            transition: all 0.3s ease !important;
                            word-break: break-all !important;
                            overflow-wrap: break-word !important;
                        }

                        .prose a:hover {
                            color: #8B5CF6 !important;
                            text-decoration: underline !important;
                        }

                        .prose blockquote {
                            margin: 1.5rem 0 !important;
                            padding: 1.5rem !important;
                            background: #F9FAFB !important;
                            border-left: 4px solid #6366F1 !important;
                            border-radius: 0 0.5rem 0.5rem 0 !important;
                            font-style: italic !important;
                            color: #6B7280 !important;
                        }

                        .prose blockquote p:last-child {
                            margin-bottom: 0 !important;
                        }

                        .prose code {
                            background: #F9FAFB !important;
                            padding: 0.2em 0.4em !important;
                            border-radius: 0.25rem !important;
                            font-size: 0.9em !important;
                            color: #DB2777 !important;
                            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace !important;
                            word-break: break-all !important;
                            overflow-wrap: break-word !important;
                        }

                        .prose pre {
                            background: #F9FAFB !important;
                            padding: 1.5rem !important;
                            border-radius: 0.5rem !important;
                            border: 1px solid #E5E7EB !important;
                            overflow-x: auto !important;
                            margin-bottom: 1.5rem !important;
                            white-space: pre-wrap !important;
                            word-wrap: break-word !important;
                        }

                        .prose pre code {
                            background: none !important;
                            padding: 0 !important;
                            color: #6B7280 !important;
                            font-size: 0.875rem !important;
                        }

                        .prose table {
                            width: 100% !important;
                            margin-bottom: 1.5rem !important;
                            background-color: transparent !important;
                            border-collapse: collapse !important;
                            border: 1px solid #D1D5DB !important;
                            border-radius: 0.5rem !important;
                            overflow: hidden !important;
                        }

                        .prose table th, .prose table td {
                            padding: 0.75rem !important;
                            vertical-align: top !important;
                            border-top: 1px solid #D1D5DB !important;
                            word-wrap: break-word !important;
                            overflow-wrap: break-word !important;
                        }

                        .prose table th {
                            background-color: #F9FAFB !important;
                            font-weight: 600 !important;
                            color: #6B7280 !important;
                            border-top: none !important;
                        }

                        .prose table tbody tr:nth-of-type(odd) {
                            background-color: rgba(0, 0, 0, 0.02) !important;
                        }

                        .prose img {
                            max-width: 100% !important;
                            height: auto !important;
                            border-radius: 0.5rem !important;
                            margin: 1rem 0 !important;
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
                            transition: all 0.3s ease !important;
                        }

                        .prose img:hover {
                            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
                            transform: translateY(-2px) !important;
                        }

                        .prose hr {
                            margin: 2rem 0 !important;
                            border: none !important;
                            height: 2px !important;
                            background: linear-gradient(90deg, transparent, #D1D5DB, transparent) !important;
                        }

                        /* Word Break */
                        .prose * {
                            max-width: 100% !important;
                            word-wrap: break-word !important;
                            overflow-wrap: break-word !important;
                        }

                        .prose a, .prose code, .prose pre {
                            word-break: break-all !important;
                            overflow-wrap: break-word !important;
                            hyphens: none !important;
                        }
                    `;
                    document.head.appendChild(style);
                });
            </script>
        @endpush
@endsection