<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Menunggu Verifikasi - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }


        .floating-animation:nth-child(2) {
            animation-delay: 2s;
        }

        .floating-animation:nth-child(3) {
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .pulse-animation {
            animation: pulse-scale 2s ease-in-out infinite;
        }

        @keyframes pulse-scale {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .loading-dots {
            animation: loading 1.4s ease-in-out infinite both;
        }

        .loading-dots:nth-child(1) {
            animation-delay: -0.32s;
        }

        .loading-dots:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes loading {

            0%,
            80%,
            100% {
                transform: scale(0);
                opacity: 0.5;
            }

            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }

        /* Clock animation */
        .clock-hand {
            animation: clockTick 2s linear infinite;
            transform-origin: bottom center;
        }

        @keyframes clockTick {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Floating shapes */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }

        .shape-1 {
            width: 200px;
            height: 200px;
            background: #f093fb;
            top: 10%;
            right: 15%;
            animation: floatShape 8s ease-in-out infinite;
        }

        .shape-2 {
            width: 150px;
            height: 150px;
            background: #667eea;
            bottom: 20%;
            left: 10%;
            animation: floatShape 6s ease-in-out infinite reverse;
        }

        .shape-3 {
            width: 100px;
            height: 100px;
            background: #764ba2;
            top: 60%;
            right: 25%;
            animation: floatShape 10s ease-in-out infinite;
        }

        @keyframes floatShape {

            0%,
            100% {
                transform: translateY(0px) translateX(0px) rotate(0deg);
            }

            25% {
                transform: translateY(-20px) translateX(10px) rotate(90deg);
            }

            50% {
                transform: translateY(-10px) translateX(-10px) rotate(180deg);
            }

            75% {
                transform: translateY(-30px) translateX(15px) rotate(270deg);
            }
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Floating decorative shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <!-- Floating decorative icons -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Shield icon -->
        <div class="floating-animation absolute top-20 left-20 text-white opacity-10">
            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11H16V16H8V11H9.2V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.4,8.7 10.4,10V11H13.6V10C13.6,8.7 12.8,8.2 12,8.2Z" />
            </svg>
        </div>
        <!-- Clock icon -->
        <div class="floating-animation absolute top-40 right-20 text-white opacity-10">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.7L16.2,16.2Z" />
            </svg>
        </div>
        <!-- Star icon -->
        <div class="floating-animation absolute bottom-20 left-32 text-yellow-300 opacity-20">
            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.46,13.97L5.82,21L12,17.27Z" />
            </svg>
        </div>
        <!-- Check circle icon -->
        <div class="floating-animation absolute bottom-32 right-32 text-green-300 opacity-20">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z" />
            </svg>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full max-w-lg relative z-10">
        <!-- Main Card -->
        <div class="glass-effect rounded-3xl p-8 shadow-2xl text-center">
            <!-- Animated Clock Icon -->
            <div class="relative mb-8">
                <div
                    class="pulse-animation inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.7L16.2,16.2Z" />
                        <!-- Animated clock hand -->
                        <line class="clock-hand stroke-current stroke-2" x1="12" y1="12" x2="12"
                            y2="7" style="stroke-width:1.5;" />
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Menunggu Verifikasi
            </h1>

            <!-- Subtitle -->
            <div
                class="bg-gradient-to-r from-indigo-500 to-purple-600 bg-clip-text text-transparent font-semibold text-lg mb-6">
                Akun Mentor Anda Sedang Diproses
            </div>

            <!-- Description -->
            <p class="text-gray-600 text-base leading-relaxed mb-8 px-2">
                Terima kasih telah mendaftar sebagai mentor! Akun Anda saat ini sedang dalam proses verifikasi oleh tim
                admin. Proses ini biasanya memakan waktu
                <span class="font-semibold text-indigo-600">1-3 hari kerja</span>.
            </p>

            <!-- Status Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                ✓
                            </div>
                            <div class="ml-3 text-left">
                                <p class="text-sm font-medium text-gray-800">Pendaftaran</p>
                                <p class="text-xs text-gray-500">Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white">
                                <div class="flex space-x-1">
                                    <div class="w-1 h-1 bg-white rounded-full loading-dots"></div>
                                    <div class="w-1 h-1 bg-white rounded-full loading-dots"></div>
                                    <div class="w-1 h-1 bg-white rounded-full loading-dots"></div>
                                </div>
                            </div>
                            <div class="ml-3 text-left">
                                <p class="text-sm font-medium text-gray-800">Verifikasi</p>
                                <p class="text-xs text-gray-500">Sedang diproses...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 text-sm">
                                3
                            </div>
                            <div class="ml-3 text-left">
                                <p class="text-sm font-medium text-gray-500">Aktif</p>
                                <p class="text-xs text-gray-400">Menunggu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M11,17H13V11H11V17Z" />
                    </svg>
                    <div class="text-left">
                        <p class="text-sm font-medium text-blue-800">Apa yang terjadi selanjutnya?</p>
                        <p class="text-xs text-blue-600 mt-1">
                            Tim admin akan meninjau kredensial dan pengalaman Anda. Anda akan menerima email notifikasi
                            setelah proses verifikasi selesai.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <!-- Back to Login Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="btn-hover w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg inline-flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M10,17L15,12L10,7V10H4V14H10V17M21,3A2,2 0 0,1 23,5V19A2,2 0 0,1 21,21H7A2,2 0 0,1 5,19V18H7V19H21V5H7V6H5V5A2,2 0 0,1 7,3H21Z" />
                        </svg>
                        <span>Kembali ke Halaman Login</span>
                    </button>
                </form>

                <!-- Contact Support Button -->
                <button
                    class="w-full bg-white border-2 border-gray-200 hover:border-indigo-300 text-gray-700 hover:text-indigo-600 font-medium py-3 px-6 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 inline-flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12,2C6.48,2 2,6.48 2,12C2,17.52 6.48,22 12,22A10,10 0 0,0 22,12C22,6.48 17.52,2 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M11,16V18H13V16H11M12.5,7.5A2.5,2.5 0 0,0 10,10H11.5A1,1 0 0,1 12.5,9A1,1 0 0,1 13.5,10A1,1 0 0,1 12.5,11C12.1,11 11.7,11.4 11.7,11.75V13H13.2V12.25A2.5,2.5 0 0,0 12.5,7.5Z" />
                    </svg>
                    <span>Butuh Bantuan?</span>
                </button>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <p class="text-white/80 text-sm">
                Proses verifikasi memastikan kualitas mentor terbaik untuk siswa kami.
            </p>
        </div>
    </div>
</body>

</html>

