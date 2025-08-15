<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }
        .shape-1 {
            width: 300px;
            height: 300px;
            background: #f093fb;
            top: -100px;
            right: -100px;
        }
        .shape-2 {
            width: 200px;
            height: 200px;
            background: #667eea;
            bottom: -50px;
            left: -50px;
        }
        .shape-3 {
            width: 150px;
            height: 150px;
            background: #764ba2;
            top: 50%;
            right: 10%;
        }
        .input-floating {
            transition: all 0.3s ease;
        }
        .input-floating:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.15);
        }
        .btn-hover {
            transition: all 0.3s ease;
        }
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }

        /* Mobile Responsive Styles */
        @media (max-width: 1023px) {
            .floating-shape {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .shape-1, .shape-2, .shape-3 {
                display: none;
            }
        }

        /* Mobile gradient header */
        .mobile-gradient-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 120px;
            position: relative;
            overflow: hidden;
        }

        .mobile-gradient-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255,255,255,0.05) 10px,
                rgba(255,255,255,0.05) 20px
            );
            animation: float-pattern 20s linear infinite;
        }

        @keyframes float-pattern {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Tablet adjustments */
        @media (min-width: 768px) and (max-width: 1023px) {
            .tablet-container {
                max-width: 500px;
            }
        }

        /* Form adjustments for register */
        .form-container {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        @media (max-width: 1023px) {
            .form-container {
                max-height: none;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Mobile gradient header -->
    <div class="mobile-gradient-header lg:hidden relative">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <svg class="w-12 h-12 mx-auto mb-2 opacity-90" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12,3L1,9L12,15L21,10.09V17H23V9L12,3M5,13.18V17.18L12,21L19,17.18V13.18L12,17L5,13.18Z"/>
                </svg>
                <h2 class="text-xl font-bold">Bergabung Bersama Kami!</h2>
            </div>
        </div>
    </div>

    <div class="flex min-h-screen lg:min-h-screen">
        <!-- Decorative shapes (hidden on mobile) -->
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>

        <!-- Left side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-6 lg:p-8 relative z-10">
            <div class="w-full max-w-md tablet-container">
                <!-- Header (hidden on mobile, visible on lg+) -->
                <div class="text-center mb-6 lg:mb-8 hidden lg:block">
                    <div class="inline-flex items-center justify-center w-14 h-14 lg:w-16 lg:h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg mb-4 lg:mb-6">
                        <svg class="w-7 h-7 lg:w-8 lg:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,3L1,9L12,15L21,10.09V17H23V9L12,3M5,13.18V17.18L12,21L19,17.18V13.18L12,17L5,13.18Z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Register</h1>
                    <p class="text-gray-600 text-sm lg:text-base">Daftar sekarang dan mulai perjalanan pembelajaran Anda</p>
                </div>

                <!-- Mobile header -->
                <div class="text-center mb-6 lg:hidden">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Register</h1>
                    <p class="text-gray-600 text-sm">Daftar sekarang dan mulai perjalanan pembelajaran Anda</p>
                </div>

                <!-- Registration Form -->
                <div class="bg-white rounded-2xl lg:rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 form-container">
                    <form method="POST" action="{{ route('register') }}" class="space-y-5 lg:space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/>
                                    </svg>
                                </div>
                                <x-text-input id="name"
                                             class="input-floating w-full pl-10 pr-4 py-3 lg:py-4 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm lg:text-base"
                                             type="text"
                                             name="name"
                                             :value="old('name')"
                                             required
                                             autofocus
                                             autocomplete="name"
                                             placeholder="Masukkan nama lengkap Anda" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12.713l-11.985-9.713h23.97l-11.985 9.713zm0 2.574l-12-9.725v15.438h24v-15.438l-12 9.725z"/>
                                    </svg>
                                </div>
                                <x-text-input id="email"
                                             class="input-floating w-full pl-10 pr-4 py-3 lg:py-4 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm lg:text-base"
                                             type="email"
                                             name="email"
                                             :value="old('email')"
                                             required
                                             autocomplete="username"
                                             placeholder="Masukkan email Anda" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18,8h-1V6A5,5 0 0,0 12,1A5,5 0 0,0 7,6V8H6A2,2 0 0,0 4,10V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V10A2,2 0 0,0 18,8M12,3A3,3 0 0,1 15,6V8H9V6A3,3 0 0,1 12,3Z"/>
                                    </svg>
                                </div>
                                <x-text-input id="password"
                                             class="input-floating w-full pl-10 pr-12 py-3 lg:py-4 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm lg:text-base"
                                             type="password"
                                             name="password"
                                             required
                                             autocomplete="new-password"
                                             placeholder="Masukkan password Anda" />
                                <button type="button"
                                        class="absolute inset-y-0 right-0 pr-3 lg:pr-4 flex items-center"
                                        onclick="togglePassword('password')">
                                    <svg id="password-eye-open" class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400 hover:text-indigo-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                                    </svg>
                                    <svg id="password-eye-closed" class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400 hover:text-indigo-500 transition-colors hidden" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.83,9L15,12.16V12A3,3 0 0,0 12,9H11.83M7.53,9.8L9.08,11.35C9.03,11.56 9,11.77 9,12A3,3 0 0,0 12,15C12.22,15 12.44,14.97 12.65,14.92L14.2,16.47C13.53,16.8 12.79,17 12,17A5,5 0 0,1 7,12C7,11.21 7.2,10.47 7.53,9.8M2,4.27L4.28,6.55L4.73,7C3.08,8.3 1.78,10 1,12C2.73,16.39 7,19.5 12,19.5C13.55,19.5 15.03,19.2 16.38,18.66L16.81,19.09L19.73,22L21,20.73L3.27,3M12,7A5,5 0 0,1 17,12C17,12.64 16.87,13.26 16.64,13.82L19.57,16.75C21.07,15.5 22.27,13.86 23,12C21.27,7.61 17,4.5 12,4.5C10.6,4.5 9.26,4.75 8,5.2L10.17,7.35C10.76,7.13 11.37,7 12,7Z"/>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21,2H3A1,1 0 0,0 2,3V21A1,1 0 0,0 3,22H21A1,1 0 0,0 22,21V3A1,1 0 0,0 21,2M19,20H5V4H19V20M10.91,16.29L8.41,13.79L7,15.21L10.91,19.12L17.91,12.12L16.5,10.71L10.91,16.29Z"/>
                                    </svg>
                                </div>
                                <x-text-input id="password_confirmation"
                                             class="input-floating w-full pl-10 pr-12 py-3 lg:py-4 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm lg:text-base"
                                             type="password"
                                             name="password_confirmation"
                                             required
                                             autocomplete="new-password"
                                             placeholder="Konfirmasi password Anda" />
                                <button type="button"
                                        class="absolute inset-y-0 right-0 pr-3 lg:pr-4 flex items-center"
                                        onclick="togglePassword('password_confirmation')">
                                    <svg id="confirm-password-eye-open" class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400 hover:text-indigo-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                                    </svg>
                                    <svg id="confirm-password-eye-closed" class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400 hover:text-indigo-500 transition-colors hidden" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.83,9L15,12.16V12A3,3 0 0,0 12,9H11.83M7.53,9.8L9.08,11.35C9.03,11.56 9,11.77 9,12A3,3 0 0,0 12,15C12.22,15 12.44,14.97 12.65,14.92L14.2,16.47C13.53,16.8 12.79,17 12,17A5,5 0 0,1 7,12C7,11.21 7.2,10.47 7.53,9.8M2,4.27L4.28,6.55L4.73,7C3.08,8.3 1.78,10 1,12C2.73,16.39 7,19.5 12,19.5C13.55,19.5 15.03,19.2 16.38,18.66L16.81,19.09L19.73,22L21,20.73L3.27,3M12,7A5,5 0 0,1 17,12C17,12.64 16.87,13.26 16.64,13.82L19.57,16.75C21.07,15.5 22.27,13.86 23,12C21.27,7.61 17,4.5 12,4.5C10.6,4.5 9.26,4.75 8,5.2L10.17,7.35C10.76,7.13 11.37,7 12,7Z"/>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
                        </div>

                        <!-- Role Selection -->
                        <div>
                            <x-input-label for="role" :value="__('Daftar sebagai')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M16,4C16.88,4 17.67,4.5 18,5.26L19,7.24C19.6,8.6 18.6,10.1 17.1,10.1H14.9C13.4,10.1 12.4,8.6 13,7.24L14,5.26C14.33,4.5 15.12,4 16,4M16,8.86L15.5,7.86L16.5,7.86L16,8.86M12.94,12.5A3.5,3.5 0 0,1 16,11A3.5,3.5 0 0,1 19.06,12.5C19.64,13.5 19.64,14.75 19.06,15.75A3.5,3.5 0 0,1 16,17.25A3.5,3.5 0 0,1 12.94,15.75C12.36,14.75 12.36,13.5 12.94,12.5M17.67,13.83C17.33,13.33 16.67,13.33 16.33,13.83L15.67,14.83C15.33,15.33 15.33,16 15.67,16.5C16,17 16.67,17 17,16.5L17.67,15.5C18,15 18,14.33 17.67,13.83M8,2A6,6 0 0,1 14,8A6,6 0 0,1 8,14A6,6 0 0,1 2,8A6,6 0 0,1 8,2M8,4A4,4 0 0,0 4,8A4,4 0 0,0 8,12A4,4 0 0,0 12,8A4,4 0 0,0 8,4M1,18V22H15V18C15,16 11,15 8,15C5,15 1,16 1,18Z"/>
                                    </svg>
                                </div>
                                <select name="role" id="role"
                                       class="input-floating w-full pl-10 pr-4 py-3 lg:py-4 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm lg:text-base"
                                       required>
                                    <option value="" class="text-gray-900">Pilih peran Anda</option>
                                    <option value="siswa" class="text-gray-900">Siswa</option>
                                    <option value="mentor" class="text-gray-900">Mentor (butuh verifikasi)</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-500 text-sm" />
                        </div>

                        <!-- Submit Button -->
                        <x-primary-button class="btn-hover w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3 lg:py-4 px-4 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg justify-center text-sm lg:text-base">
                            {{ __('Register') }}
                        </x-primary-button>

                        <!-- Login Link -->
                        <div class="text-center pt-4 border-t border-gray-100">
                            <p class="text-gray-600 text-sm">
                                Sudah memiliki akun?
                                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 transition-colors font-medium">
                                    Masuk sekarang
                                </a>
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Mobile Statistics -->
                <div class="grid grid-cols-2 gap-4 mt-6 lg:hidden">
                    <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100">
                        <div class="text-xl lg:text-2xl font-bold text-indigo-600 mb-1">10K+</div>
                        <div class="text-xs text-gray-600">Siswa Aktif</div>
                    </div>
                    <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100">
                        <div class="text-xl lg:text-2xl font-bold text-indigo-600 mb-1">100+</div>
                        <div class="text-xs text-gray-600">Kursus Tersedia</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Gradient Background with Decorative Elements (Desktop only) -->
        <div class="hidden lg:flex lg:w-1/2 gradient-bg items-center justify-center relative overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute top-10 left-10 w-16 xl:w-20 h-16 xl:h-20 bg-white bg-opacity-10 rounded-full"></div>
            <div class="absolute top-32 right-20 w-12 xl:w-16 h-12 xl:h-16 bg-white bg-opacity-20 rounded-full"></div>
            <div class="absolute bottom-20 left-20 w-10 xl:w-12 h-10 xl:h-12 bg-white bg-opacity-15 rounded-full"></div>
            <div class="absolute bottom-40 right-32 w-6 xl:w-8 h-6 xl:h-8 bg-white bg-opacity-25 rounded-full"></div>

            <!-- Main content -->
            <div class="text-center text-white px-8">
                <div class="mb-8">
                    <svg class="w-20 xl:w-24 h-20 xl:h-24 mx-auto mb-6 opacity-90" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,3L1,9L12,15L21,10.09V17H23V9L12,3M5,13.18V17.18L12,21L19,17.18V13.18L12,17L5,13.18Z"/>
                    </svg>
                </div>
                <h2 class="text-3xl xl:text-4xl font-bold mb-4">Bergabung Bersama Kami!</h2>
                <p class="text-lg xl:text-xl opacity-90 mb-8 leading-relaxed">
                    Daftar sekarang dan mulai perjalanan pembelajaran yang luar biasa
                </p>

                <!-- Statistics -->
                <div class="grid grid-cols-2 gap-6 max-w-xs mx-auto">
                    <div class="text-center">
                        <div class="text-2xl xl:text-3xl font-bold mb-2">10K+</div>
                        <div class="text-sm opacity-80">Siswa Aktif</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl xl:text-3xl font-bold mb-2">100+</div>
                        <div class="text-sm opacity-80">Kursus Tersedia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const prefix = fieldId === 'password' ? 'password' : 'confirm-password';
            const eyeOpen = document.getElementById(`${prefix}-eye-open`);
            const eyeClosed = document.getElementById(`${prefix}-eye-closed`);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        // Add validation feedback for password confirmation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = '#ef4444';
            } else if (confirmPassword && password === confirmPassword) {
                this.style.borderColor = '#22c55e';
            } else {
                this.style.borderColor = '';
            }
        });

        // Add subtle animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.bg-white');
            form.style.opacity = '0';
            form.style.transform = 'translateY(20px)';

            setTimeout(() => {
                form.style.transition = 'all 0.6s ease';
                form.style.opacity = '1';
                form.style.transform = 'translateY(0)';
            }, 100);
        });

        // Add focus effects for inputs
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-105');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-105');
            });
        });
    </script>
</body>
</html>
