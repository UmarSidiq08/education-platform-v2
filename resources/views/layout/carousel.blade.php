<style>
/* ===== SOLUSI UNTUK MENGHILANGKAN GAP NAVBAR ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

.carousel-wrapper {
    margin: 0 !important;
    padding: 0;
}

nav, .navbar {
    margin-bottom: 0 !important;
}
/* ===== END SOLUSI GAP NAVBAR ===== */

/* CSS carousel Anda yang sudah ada di sini */
.carousel-wrapper {
    /* styling carousel existing */
}
</style>
<section class="carousel-wrapper">
    <div class="carousel-container">
        <!-- Background Elements -->
        <div class="carousel-bg-effects">
            <div class="bg-particle particle-1"></div>
            <div class="bg-particle particle-2"></div>
            <div class="bg-particle particle-3"></div>
            <div class="bg-particle particle-4"></div>
            <div class="bg-gradient-overlay"></div>
        </div>

        <!-- Main Carousel -->
        <div class="carousel">
            <!-- Slide 1 -->
            <div class="carousel-slide active" data-slide="1">
                <div class="slide-background slide-bg-1">
                    <div class="slide-pattern"></div>
                </div>
                <div class="slide-content">
                    <div class="content-badge">⚡ Quick Learning</div>
                    <h2 class="slide-title">Cara menjadi jago dalam waktu 2 jam</h2>
                    <p class="slide-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
                        imperdiet tincidunt nunc, i.</p>
                    <div class="slide-stats">
                        <div class="stat-item">
                            <span class="stat-number">2k+</span>
                            <span class="stat-label">Students</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">4.9</span>
                            <span class="stat-label">Rating</span>
                        </div>
                    </div>
                    <a href="{{ route('navbar.classes') }}">
                        <button class="slide-cta-btn">Mulai Belajar <span>→</span></button>
                    </a>
                </div>
                <div class="slide-visual">
                    <img src="{{ asset('images/GambarC-1.png') }}" alt="Leaderboard Illustration" class="leaderboard-image" >
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-slide" data-slide="2">
                <div class="slide-background slide-bg-2">
                    <div class="slide-pattern"></div>
                </div>
                <div class="slide-content">
                    <div class="content-badge">👨‍🏫 Expert Mentors</div>
                    <h2 class="slide-title">Belajar dengan mentor terbaik</h2>
                    <p class="slide-description">Bergabunglah dengan ribuan siswa yang telah merasakan pengalaman
                        belajar yang luar biasa bersama mentor-mentor terpilih kami. Dapatkan bimbingan personal
                        yang efektif.</p>
                    <div class="slide-stats">
                        <div class="stat-item">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">Mentors</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">95%</span>
                            <span class="stat-label">Success</span>
                        </div>
                    </div>
                    <a href="{{ route('navbar.mentor') }}" class="slide-cta-btn">
                        <span>Find Mentor</span> <span>→</span>
                    </a>
                </div>
                <div class="slide-visual">
                                        <img src="{{ asset('images/GambarC-2.png') }}" alt="Leaderboard Illustration" class="leaderboard-image">

                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-slide" data-slide="3">
                <div class="slide-background slide-bg-3">
                    <div class="slide-pattern"></div>
                </div>
                <div class="slide-content">
                    <div class="content-badge">🏆 Leaderboard</div>
                    <h2 class="slide-title">Raih prestasi maksimal bersama</h2>
                    <p class="slide-description">Kompetisi sehat dan lingkungan belajar yang mendukung akan
                        memotivasi kamu untuk terus berkembang. Bergabunglah dengan komunitas pelajar yang aktif.
                    </p>
                    <div class="slide-stats">
                        <div class="stat-item">
                            <span class="stat-number">10k+</span>
                            <span class="stat-label">Community</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Support</span>
                        </div>
                    </div>
                    <button class="slide-cta-btn">Join Now <span>→</span></button>
                </div>
                <div class="slide-visual">
                    <img src="{{ asset('images/gambarC-3.png') }}" alt="Leaderboard Illustration" class="leaderboard-image " style="width: autow;" class="shadow-lg p-3 mb-5 bg-body rounded" >
                </div>
            </div>
        </div>

        <!-- Enhanced Navigation -->
        <div class="carousel-navigation">
            <button class="nav-arrow nav-prev" onclick="changeSlide(-1)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15,18 9,12 15,6"></polyline>
                </svg>
            </button>
            <button class="nav-arrow nav-next" onclick="changeSlide(1)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"></polyline>
                </svg>
            </button>
        </div>

        <!-- Enhanced Dots -->
        <div class="carousel-dots">
            <div class="dot active" onclick="goToSlide(0)" data-slide="1">
                <span class="dot-progress"></span>
            </div>
            <div class="dot" onclick="goToSlide(1)" data-slide="2">
                <span class="dot-progress"></span>
            </div>
            <div class="dot" onclick="goToSlide(2)" data-slide="3">
                <span class="dot-progress"></span>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="carousel-progress">
            <div class="progress-bar"></div>
        </div>
    </div>
</section>

<!-- Bottom Section -->
<section class="bottom-section">
    <div class="brand-section">
        <h1 class="brand-title">Lumina</h1>
        <p class="brand-subtitle">Teman Setia Waktu Kamu Belajar</p>
            <a href="{{ route('classes.index') }}" class="cta-button">Start learning</a>
    </div>
</section>

