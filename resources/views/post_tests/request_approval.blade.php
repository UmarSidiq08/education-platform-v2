@extends('layouts.app')

@section('content')
<style>
    .bg-main-gradient {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .bg-warning-gradient {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .bg-warning-gradient:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    .attempt-card {
        transition: all 0.3s ease;
    }

    .attempt-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>

<div class="bg-main-gradient min-h-screen -mx-4 -mt-5 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto px-8 py-8 font-sans">
        <!-- Header Section -->
        <div class="relative mb-12 p-8 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl text-white overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-4xl font-extrabold mb-2">
                    <i class="fas fa-hand-paper me-3"></i>Request Approval Mentor
                </h1>
                <p class="text-lg opacity-90 mb-6">Minta izin kepada mentor untuk percobaan tambahan</p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('classes.show', $postTest->class->id) }}"
                        class="group inline-flex items-center gap-2 px-6 py-3 bg-white text-orange-600 font-semibold rounded-lg transition-all duration-300 hover:bg-orange-50 hover:-translate-y-1">
                        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                        <span>Kembali ke Kelas</span>
                    </a>
                </div>
            </div>

            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute top-1/2 right-24 w-36 h-36 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute -bottom-8 right-48 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="relative -mt-12 z-10">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-8">
                    <!-- Info Alert -->
                    <div class="bg-orange-50 border-l-4 border-orange-400 p-6 rounded-lg mb-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-orange-400 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-orange-800 mb-2">Perlu Approval Mentor</h3>
                                <p class="text-orange-700">
                                    Anda sudah mengerjakan post test ini 2 kali dengan nilai di bawah 80%.
                                    Untuk dapat mengerjakan lagi, Anda perlu meminta approval dari mentor.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Attempt History Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-history text-indigo-500"></i>
                            Riwayat Percobaan Anda
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($attempts as $attempt)
                                <div class="attempt-card bg-gradient-to-r {{ $attempt->getPercentageAttribute() >= 80 ? 'from-green-50 to-green-100 border-green-200' : 'from-red-50 to-red-100 border-red-200' }} border rounded-xl p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 {{ $attempt->getPercentageAttribute() >= 80 ? 'bg-green-500' : 'bg-red-500' }} rounded-full flex items-center justify-center text-white font-bold">
                                                {{ $attempt->attempt_number }}
                                            </div>
                                            <div>
                                                <h4 class="font-semibold {{ $attempt->getPercentageAttribute() >= 80 ? 'text-green-800' : 'text-red-800' }}">
                                                    Attempt #{{ $attempt->attempt_number }}
                                                </h4>
                                                <p class="text-sm {{ $attempt->getPercentageAttribute() >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $attempt->finished_at->format('d M Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold {{ $attempt->getPercentageAttribute() >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $attempt->getPercentageAttribute() }}%
                                            </div>
                                            <div class="text-xs {{ $attempt->getPercentageAttribute() >= 80 ? 'text-green-500' : 'text-red-500' }}">
                                                {{ $attempt->getPercentageAttribute() >= 80 ? 'LULUS' : 'TIDAK LULUS' }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-1000 {{ $attempt->getPercentageAttribute() >= 80 ? 'bg-gradient-to-r from-green-400 to-green-600' : 'bg-gradient-to-r from-red-400 to-red-600' }}"
                                             style="width: {{ $attempt->getPercentageAttribute() }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Request Form Section -->
                    <div class="bg-gray-50 rounded-xl p-8 border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-paper-plane text-orange-500"></i>
                            Kirim Permintaan Approval
                        </h3>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-lightbulb text-blue-500 text-xl mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-blue-800 mb-1">Yang Akan Terjadi:</h4>
                                    <ul class="text-blue-700 text-sm space-y-1">
                                        <li>• Mentor akan menerima notifikasi permintaan Anda</li>
                                        <li>• Setelah disetujui, Anda dapat mengerjakan post test lagi</li>
                                        <li>• Anda akan mendapat notifikasi setelah mentor memproses</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('post_tests.request_approval.submit', $postTest) }}" method="POST">
                            @csrf

                            <!-- Post Test Info -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200 mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                                    <div>
                                        <div class="text-sm text-gray-600">Post Test</div>
                                        <div class="font-semibold text-gray-800">{{ $postTest->title ?? 'Post Test Kelas' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-600">Kelas</div>
                                        <div class="font-semibold text-gray-800">{{ $postTest->class->name }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-600">Passing Score</div>
                                        <div class="font-semibold text-orange-600">80%</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                                <a href="{{ route('classes.show', $postTest->class->id) }}"
                                   class="w-full sm:w-auto order-2 sm:order-1 bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition-all duration-300 hover:-translate-y-0.5 text-center no-underline">
                                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                                </a>

                                <button type="submit"
                                        class="w-full sm:w-auto order-1 sm:order-2 bg-warning-gradient text-white px-8 py-3 rounded-lg font-bold text-lg hover:-translate-y-0.5 transition-all duration-300 shadow-lg"
                                        onclick="return confirm('Kirim permintaan approval ke mentor?')">
                                    <i class="fas fa-paper-plane mr-2"></i>Kirim Permintaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
