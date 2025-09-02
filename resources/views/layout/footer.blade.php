<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer with Tailwind CSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#4fc3f7',
                        'primary-dark': '#29b6f6',
                        'footer-bg-1': '#1a1a2e',
                        'footer-bg-2': '#16213e',
                        'footer-bg-3': '#0f172a',
                    },
                    animation: {
                        'float-particles': 'floatParticles 15s ease-in-out infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes floatParticles {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(20px, -20px) rotate(90deg);
            }
            50% {
                transform: translate(-15px, -30px) rotate(180deg);
            }
            75% {
                transform: translate(-20px, 15px) rotate(270deg);
            }
        }

        .bg-gradient-footer {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f172a 100%);
        }

        .bg-gradient-logo {
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bg-gradient-instagram {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        .particle-blur {
            backdrop-filter: blur(10px);
        }

        .animation-delay-0 {
            animation-delay: 0s;
        }

        .animation-delay-5 {
            animation-delay: -5s;
        }

        .animation-delay-10 {
            animation-delay: -10s;
        }
    </style>
</head>

<body class="font-inter">
    <!-- Demo content to show scrolling -->


    <footer class="bg-gradient-footer text-white relative overflow-hidden">
        <div class="relative z-10 pt-8 sm:pt-12">
            <!-- Main Footer Grid -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                <!-- Company Info Column -->
                <div class="lg:col-span-4 xl:col-span-3 order-1">
                    <div class="flex items-center gap-3 mb-4 justify-center sm:justify-start">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 bg-gradient-logo rounded-lg flex items-center justify-center text-lg sm:text-xl shadow-lg shadow-primary/30">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-gradient">Lumina</h3>
                    </div>
                    <p class="text-slate-300 leading-relaxed mb-6 text-sm text-center sm:text-left max-w-sm mx-auto sm:max-w-none sm:mx-0">
                        Teman setia waktu kamu belajar. Bergabunglah dengan ribuan siswa yang telah merasakan pengalaman
                        belajar yang luar biasa bersama kami.
                    </p>

                    <div class="flex gap-2 sm:gap-3 justify-center sm:justify-start flex-wrap">
                        <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center bg-white/10 text-white border border-white/10 particle-blur transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-black/20 hover:bg-[#3b5998] hover:border-[#3b5998] text-sm">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center bg-white/10 text-white border border-white/10 particle-blur transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-black/20 hover:bg-[#1da1f2] hover:border-[#1da1f2] text-sm">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center bg-white/10 text-white border border-white/10 particle-blur transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-black/20 hover:bg-gradient-instagram hover:border-[#e6683c] text-sm">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center bg-white/10 text-white border border-white/10 particle-blur transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-black/20 hover:bg-[#ff0000] hover:border-[#ff0000] text-sm">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center bg-white/10 text-white border border-white/10 particle-blur transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-black/20 hover:bg-[#0077b5] hover:border-[#0077b5] text-sm">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links & Programs Combined (Mobile Side by Side) -->
                <div class="col-span-1 sm:col-span-2 lg:col-span-4 xl:col-span-4 order-2 lg:order-2">
                    <div class="grid grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8 text-center sm:text-left">
                        <!-- Quick Links -->
                        <div>
                            <h4 class="flex items-center gap-2 text-base sm:text-lg font-bold mb-4 sm:mb-5 text-white justify-center sm:justify-start">
                                <i class="fas fa-link w-4 text-primary text-sm"></i>
                                <span class="hidden xs:inline sm:inline">Quick Links</span>
                                <span class="xs:hidden sm:hidden text-sm">Links</span>
                            </h4>
                            <div class="flex flex-col space-y-2">
                                <a href="#about" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Tentang Kami</a>
                                <a href="#courses" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Kursus</a>
                                <a href="#mentors" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Mentor</a>
                                <a href="#pricing" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Harga</a>
                                <a href="#blog" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Blog</a>
                                <a href="#career" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Karir</a>
                            </div>
                        </div>

                        <!-- Programs -->
                        <div>
                            <h4 class="flex items-center gap-2 text-base sm:text-lg font-bold mb-4 sm:mb-5 text-white justify-center sm:justify-start">
                                <i class="fas fa-code w-4 text-primary text-sm"></i>
                                <span class="hidden xs:inline sm:inline">Program</span>
                                <span class="xs:hidden sm:hidden text-sm">Program</span>
                            </h4>
                            <div class="flex flex-col space-y-2">
                                <a href="#web-dev" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Web Development</a>
                                <a href="#mobile-dev" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Mobile Development</a>
                                <a href="#data-science" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Data Science</a>
                                <a href="#ui-ux" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">UI/UX Design</a>
                                <a href="#digital-marketing" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Digital Marketing</a>
                                <a href="#cyber-security" class="text-slate-300 text-sm transition-all duration-300 pl-0 sm:pl-3 relative hover:text-primary sm:hover:pl-5 before:content-['→'] before:absolute before:left-0 before:opacity-0 before:-translate-x-2 before:transition-all before:duration-300 before:text-primary before:text-xs hover:before:opacity-100 hover:before:translate-x-0 before:hidden sm:before:inline">Cyber Security</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info Column -->
                <div class="lg:col-span-2 xl:col-span-2 text-center sm:text-left order-3 lg:order-4">
                    <h4 class="flex items-center gap-2 text-base sm:text-lg font-bold mb-4 sm:mb-5 text-white justify-center sm:justify-start">
                        <i class="fas fa-phone w-4 text-primary text-sm"></i>
                        Kontak
                    </h4>
                    <div class="space-y-3 sm:space-y-4 max-w-xs mx-auto sm:max-w-none sm:mx-0">
                        <div class="flex items-start gap-3 p-3 bg-white/5 rounded-lg border border-white/10 transition-all duration-300 hover:bg-white/8 hover:translate-x-1">
                            <i class="fas fa-envelope text-primary text-sm w-4 mt-0.5"></i>
                            <div class="flex-1 min-w-0">
                                <span class="block text-xs text-slate-400 mb-0.5 font-medium">Email</span>
                                <span class="block text-white font-semibold text-sm break-all">info@edubuddy.id</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-white/5 rounded-lg border border-white/10 transition-all duration-300 hover:bg-white/8 hover:translate-x-1">
                            <i class="fas fa-phone text-primary text-sm w-4 mt-0.5"></i>
                            <div class="flex-1">
                                <span class="block text-xs text-slate-400 mb-0.5 font-medium">Telepon</span>
                                <span class="block text-white font-semibold text-sm">+62 21 1234 5678</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-white/5 rounded-lg border border-white/10 transition-all duration-300 hover:bg-white/8 hover:translate-x-1">
                            <i class="fas fa-map-marker-alt text-primary text-sm w-4 mt-0.5"></i>
                            <div class="flex-1">
                                <span class="block text-xs text-slate-400 mb-0.5 font-medium">Alamat</span>
                                <span class="block text-white font-semibold text-sm">Jakarta, Indonesia</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Newsletter Column -->
                <div class="lg:col-span-4 xl:col-span-3 sm:col-span-2 order-4 lg:order-5">
                    <div class="bg-white/3 p-4 sm:p-6 rounded-2xl border border-white/10 max-w-md mx-auto lg:max-w-none lg:mx-0">
                        <h4 class="flex items-center gap-2 text-base sm:text-lg font-bold mb-4 sm:mb-5 text-white justify-center sm:justify-start">
                            <i class="fas fa-bell w-4 text-primary text-sm"></i>
                            Newsletter
                        </h4>
                        <p class="text-slate-300 text-sm leading-relaxed mb-4 sm:mb-5 text-center sm:text-left">
                            Dapatkan tips belajar dan update terbaru langsung ke email kamu.
                        </p>
                        <form class="newsletter-form mb-4 sm:mb-6">
                            <div class="flex flex-col gap-3 mb-3">
                                <div class="flex bg-white/10 rounded-lg border border-white/20 overflow-hidden">
                                    <input type="email" placeholder="Email kamu..." required class="flex-1 bg-transparent border-none p-3 text-white text-sm focus:outline-none focus:bg-white/5 placeholder-white/60 min-w-0">
                                    <button type="submit" class="bg-gradient-logo text-white border-none p-3 cursor-pointer text-sm transition-all duration-300 hover:bg-gradient-to-r hover:from-primary-dark hover:to-blue-700 hover:scale-105 flex items-center justify-center w-12 flex-shrink-0">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                            <label class="flex items-start gap-2 text-slate-300 text-xs leading-relaxed cursor-pointer select-none justify-center sm:justify-start text-center sm:text-left">
                                <input type="checkbox" required class="hidden peer">
                                <span class="w-4 h-4 border-2 border-white/30 rounded flex items-center justify-center transition-all duration-300 flex-shrink-0 mt-0.5 peer-checked:bg-gradient-logo peer-checked:border-primary after:content-['✓'] after:text-white after:text-xs after:font-bold after:opacity-0 peer-checked:after:opacity-100"></span>
                                <span class="checkbox-text">Saya setuju dengan <a href="#privacy" class="text-primary hover:text-primary-dark hover:underline transition-colors duration-300">kebijakan privasi</a></span>
                            </label>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="bg-black/30 border-t border-white/10 py-4 sm:py-6 mt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row justify-between items-center gap-4 lg:gap-6">
                    <div class="text-center lg:text-left order-2 lg:order-1 w-full lg:w-auto">
                        <p class="text-slate-400 mb-2 text-xs sm:text-sm">&copy; <a href="https://www.instagram.com/gletzerg/">2025 Gletzer Julio Ivanees &</a><a href="https://www.instagram.com/umrsdiq_/"> Umar Sidiq.</a> All rights reserved.</p>
                        <div class="flex gap-3 sm:gap-5 flex-wrap justify-center lg:justify-start">
                            <a href="#privacy" class="text-slate-300 text-xs hover:text-primary transition-colors duration-300">Privacy Policy</a>
                            <a href="#terms" class="text-slate-300 text-xs hover:text-primary transition-colors duration-300">Terms of Service</a>
                            <a href="#cookies" class="text-slate-300 text-xs hover:text-primary transition-colors duration-300">Cookie Policy</a>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 sm:gap-4 order-1 lg:order-2 flex-shrink-0">
                        <div class="flex items-center gap-2 bg-white/10 py-2 px-3 rounded-lg border border-white/20">
                            <i class="fas fa-globe text-primary text-sm"></i>
                            <select class="bg-transparent border-none text-white text-xs cursor-pointer focus:outline-none">
                                <option value="id" class="bg-footer-bg-1 text-white">Bahasa Indonesia</option>
                                <option value="en" class="bg-footer-bg-1 text-white">English</option>
                            </select>
                        </div>
                        <div class="w-10 h-10 bg-gradient-logo text-white rounded-full flex items-center justify-center cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:scale-110 shadow-lg shadow-primary/30 hover:shadow-primary/40" onclick="scrollToTop()">
                            <i class="fas fa-arrow-up text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Effects -->
        <div class="absolute top-0 left-0 right-0 bottom-0 overflow-hidden z-0">
            <div class="absolute w-20 sm:w-30 h-20 sm:h-30 rounded-full opacity-5 animate-float-particles animation-delay-0 top-[15%] left-[15%]" style="background: radial-gradient(circle, #4fc3f7, transparent);"></div>
            <div class="absolute w-16 sm:w-25 h-16 sm:h-25 rounded-full opacity-5 animate-float-particles animation-delay-5 top-[60%] right-[25%]" style="background: radial-gradient(circle, #29b6f6, transparent);"></div>
            <div class="absolute w-12 sm:w-20 h-12 sm:h-20 rounded-full opacity-5 animate-float-particles animation-delay-10 bottom-[25%] left-[70%]" style="background: radial-gradient(circle, #4fc3f7, transparent);"></div>
        </div>
    </footer>

    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Newsletter form submission
        document.querySelector('.newsletter-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            const checkbox = this.querySelector('input[type="checkbox"]').checked;

            if (email && checkbox) {
                alert('Terima kasih! Kami akan mengirimkan update terbaru ke email Anda.');
                this.reset();
            } else {
                alert('Mohon isi email dan centang persetujuan.');
            }
        });
    </script>
</body>
</html>
