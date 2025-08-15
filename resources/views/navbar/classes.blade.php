@extends('layout.template')
@section('content')
    @include('layout.navbar')
    <!-- Classes Tab Content -->
    <div class="classes-container">
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Classes Content</title>
            <style>
                /* Classes Tab Styles */
                .classes-container {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: calc(100vh - 80px);
                    /* Adjust based on your navbar height */
                    padding: 40px 20px;
                }

                .classes-content {
                    max-width: 1200px;
                    margin: 0 auto;
                }


                .page-header {
                    text-align: center;
                    margin-bottom: 50px;
                }

                .page-title {
                    font-size: 3rem;
                    font-weight: 700;
                    color: white;
                    margin-bottom: 15px;
                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
                }

                .page-subtitle {
                    font-size: 1.2rem;
                    color: rgba(255, 255, 255, 0.9);
                    max-width: 600px;
                    margin: 0 auto;
                }

                /* Filter Tabs */
                .filter-tabs {
                    display: flex;
                    justify-content: center;
                    gap: 15px;
                    margin-bottom: 40px;
                    flex-wrap: wrap;
                }

                .filter-tab {
                    padding: 12px 25px;
                    background: rgba(255, 255, 255, 0.2);
                    border: none;
                    border-radius: 25px;
                    color: white;
                    font-weight: 500;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    backdrop-filter: blur(10px);
                }

                .filter-tab:hover,
                .filter-tab.active {
                    background: rgba(255, 255, 255, 0.3);
                    transform: translateY(-2px);
                }

                /* Classes Grid */
                .classes-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                    gap: 30px;
                    margin-bottom: 50px;
                }

                .class-card {
                    background: rgba(255, 255, 255, 0.95);
                    border-radius: 20px;
                    padding: 25px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    transition: all 0.3s ease;
                    backdrop-filter: blur(10px);
                    position: relative;
                    overflow: hidden;
                }

                .class-card::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 4px;
                    background: linear-gradient(45deg, #667eea, #764ba2);
                }

                .class-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
                }

                .class-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    margin-bottom: 20px;
                }

                .class-category {
                    background: linear-gradient(45deg, #667eea, #764ba2);
                    color: white;
                    padding: 5px 15px;
                    border-radius: 15px;
                    font-size: 0.8rem;
                    font-weight: 600;
                }

                .class-level {
                    background: rgba(102, 126, 234, 0.1);
                    color: #667eea;
                    padding: 5px 12px;
                    border-radius: 12px;
                    font-size: 0.8rem;
                    font-weight: 500;
                }

                .class-title {
                    font-size: 1.4rem;
                    font-weight: 700;
                    color: #333;
                    margin-bottom: 10px;
                }

                .class-description {
                    color: #666;
                    line-height: 1.6;
                    margin-bottom: 20px;
                }

                .class-info {
                    display: flex;
                    gap: 20px;
                    margin-bottom: 20px;
                    font-size: 0.9rem;
                    color: #666;
                }

                .class-info-item {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                .class-mentor {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 20px;
                }

                .mentor-avatar {
                    width: 40px;
                    height: 40px;
                    background: linear-gradient(45deg, #667eea, #764ba2);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-weight: bold;
                }

                .mentor-info h4 {
                    font-size: 0.9rem;
                    font-weight: 600;
                    color: #333;
                }

                .mentor-info p {
                    font-size: 0.8rem;
                    color: #666;
                }

                .class-footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .class-price {
                    font-size: 1.2rem;
                    font-weight: 700;
                    color: #667eea;
                }

                .enroll-btn {
                    background: linear-gradient(45deg, #667eea, #764ba2);
                    color: white;
                    border: none;
                    padding: 12px 25px;
                    border-radius: 25px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                }

                .enroll-btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
                }

                /* Stats Section */
                .stats-section {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 20px;
                    margin-top: 50px;
                }

                .stat-card {
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 15px;
                    padding: 25px;
                    text-align: center;
                    backdrop-filter: blur(10px);
                }

                .stat-number {
                    font-size: 2.5rem;
                    font-weight: 700;
                    color: white;
                    margin-bottom: 5px;
                }

                .stat-label {
                    color: rgba(255, 255, 255, 0.8);
                    font-weight: 500;
                }

                /* Responsive */
                @media (max-width: 768px) {
                    .page-title {
                        font-size: 2rem;
                    }

                    .classes-grid {
                        grid-template-columns: 1fr;
                    }

                    .class-info {
                        flex-direction: column;
                        gap: 10px;
                    }

                    .filter-tabs {
                        gap: 10px;
                    }

                    .filter-tab {
                        padding: 10px 20px;
                        font-size: 0.9rem;
                    }
                }
            </style>
        </head>

        <body>
            <!-- Classes Tab Content -->
            <div class="classes-container">
                <div class="classes-content">
                    <div class="page-header">
                        <h1 class="page-title">Kelas Tersedia</h1>
                        <p class="page-subtitle">Pilih kelas yang sesuai dengan minat dan level kemampuan Anda. Dapatkan
                            bimbingan dari mentor terbaik untuk mencapai tujuan belajar Anda.</p>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="filter-tabs">
                        <button class="filter-tab active" onclick="filterClasses('all')">Semua Kelas</button>
                        <button class="filter-tab" onclick="filterClasses('programming')">Programming</button>
                        <button class="filter-tab" onclick="filterClasses('design')">Design</button>
                        <button class="filter-tab" onclick="filterClasses('marketing')">Marketing</button>
                        <button class="filter-tab" onclick="filterClasses('business')">Business</button>
                        <button class="filter-tab" onclick="filterClasses('language')">Bahasa</button>
                    </div>

                    <!-- Classes Grid -->
                    <div class="classes-grid" id="classesGrid">
                        <!-- Programming Classes -->
                        <div class="class-card" data-category="programming">
                            <div class="class-header">
                                <span class="class-category">Programming</span>
                                <span class="class-level">Pemula</span>
                            </div>
                            <h3 class="class-title">JavaScript Fundamentals</h3>
                            <p class="class-description">Pelajari dasar-dasar JavaScript dari nol hingga mahir. Cocok untuk
                                pemula yang ingin memulai karir sebagai web developer.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 8 Minggu</div>
                                <div class="class-info-item">📚 24 Materi</div>
                                <div class="class-info-item">👥 120 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Ahmad Dhani</h4>
                                    <p>Senior JavaScript Developer</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 499.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>

                        <div class="class-card" data-category="programming">
                            <div class="class-header">
                                <span class="class-category">Programming</span>
                                <span class="class-level">Menengah</span>
                            </div>
                            <h3 class="class-title">React.js Mastery</h3>
                            <p class="class-description">Kuasai React.js untuk membangun aplikasi web modern. Pelajari
                                hooks, context API, dan best practices.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 10 Minggu</div>
                                <div class="class-info-item">📚 30 Materi</div>
                                <div class="class-info-item">👥 85 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Siti Indah</h4>
                                    <p>React Developer at Tokopedia</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 799.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>

                        <div class="class-card" data-category="programming">
                            <div class="class-header">
                                <span class="class-category">Programming</span>
                                <span class="class-level">Lanjutan</span>
                            </div>
                            <h3 class="class-title">Python Data Science</h3>
                            <p class="class-description">Belajar analisis data dan machine learning menggunakan Python.
                                Cocok untuk yang ingin berkarir di bidang data.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 12 Minggu</div>
                                <div class="class-info-item">📚 36 Materi</div>
                                <div class="class-info-item">👥 95 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Budi Prasetyo</h4>
                                    <p>Data Scientist at Gojek</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 999.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>

                        <!-- Design Classes -->
                        <div class="class-card" data-category="design">
                            <div class="class-header">
                                <span class="class-category">Design</span>
                                <span class="class-level">Pemula</span>
                            </div>
                            <h3 class="class-title">UI/UX Design Fundamentals</h3>
                            <p class="class-description">Pelajari prinsip-prinsip design thinking dan cara membuat interface
                                yang user-friendly.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 6 Minggu</div>
                                <div class="class-info-item">📚 18 Materi</div>
                                <div class="class-info-item">👥 150 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Rina Andini</h4>
                                    <p>UI/UX Designer at Bukalapak</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 399.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>

                        <div class="class-card" data-category="design">
                            <div class="class-header">
                                <span class="class-category">Design</span>
                                <span class="class-level">Menengah</span>
                            </div>
                            <h3 class="class-title">Advanced Figma Design</h3>
                            <p class="class-description">Kuasai Figma untuk membuat prototype dan design system yang
                                profesional.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 8 Minggu</div>
                                <div class="class-info-item">📚 24 Materi</div>
                                <div class="class-info-item">👥 75 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Dedi Wijaya</h4>
                                    <p>Product Designer</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 699.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>

                        <!-- Marketing Classes -->
                        <div class="class-card" data-category="marketing">
                            <div class="class-header">
                                <span class="class-category">Marketing</span>
                                <span class="class-level">Pemula</span>
                            </div>
                            <h3 class="class-title">Digital Marketing Strategy</h3>
                            <p class="class-description">Pelajari strategi pemasaran digital yang efektif untuk
                                meningkatkan brand awareness dan penjualan.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 6 Minggu</div>
                                <div class="class-info-item">📚 20 Materi</div>
                                <div class="class-info-item">👥 200 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Lisa Sari</h4>
                                    <p>Digital Marketing Manager</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 449.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>

                        <div class="class-card" data-category="marketing">
                            <div class="class-header">
                                <span class="class-category">Marketing</span>
                                <span class="class-level">Menengah</span>
                            </div>
                            <h3 class="class-title">Social Media Marketing</h3>
                            <p class="class-description">Optimalisasi media sosial untuk bisnis. Pelajari content planning,
                                engagement, dan analytics.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 8 Minggu</div>
                                <div class="class-info-item">📚 25 Materi</div>
                                <div class="class-info-item">👥 180 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Fajar Hidayat</h4>
                                    <p>Social Media Strategist</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 599.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>

                        <!-- Business Classes -->
                        <div class="class-card" data-category="business">
                            <div class="class-header">
                                <span class="class-category">Business</span>
                                <span class="class-level">Pemula</span>
                            </div>
                            <h3 class="class-title">Startup Fundamentals</h3>
                            <p class="class-description">Panduan lengkap membangun startup dari ide hingga eksekusi. Cocok
                                untuk calon entrepreneur.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 10 Minggu</div>
                                <div class="class-info-item">📚 28 Materi</div>
                                <div class="class-info-item">👥 110 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Andi Malik</h4>
                                    <p>Serial Entrepreneur</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 899.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>

                        <!-- Language Classes -->
                        <div class="class-card" data-category="language">
                            <div class="class-header">
                                <span class="class-category">Bahasa</span>
                                <span class="class-level">Pemula</span>
                            </div>
                            <h3 class="class-title">English for Professionals</h3>
                            <p class="class-description">Tingkatkan kemampuan bahasa Inggris untuk dunia kerja. Focus pada
                                business communication dan presentation skills.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 12 Minggu</div>
                                <div class="class-info-item">📚 32 Materi</div>
                                <div class="class-info-item">😹 250 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Maya Rahayu</h4>
                                    <p>English Language Instructor</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 349.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>

                        <div class="class-card" data-category="language">
                            <div class="class-header">
                                <span class="class-category">Bahasa</span>
                                <span class="class-level">Menengah</span>
                            </div>
                            <h3 class="class-title">Mandarin for Business</h3>
                            <p class="class-description">Pelajari bahasa Mandarin untuk keperluan bisnis. Cocok untuk yang
                                ingin bekerja di perusahaan multinasional.</p>
                            <div class="class-info">
                                <div class="class-info-item">⏱️ 16 Minggu</div>
                                <div class="class-info-item">📚 40 Materi</div>
                                <div class="class-info-item">👥 65 Siswa</div>
                            </div>
                            <div class="class-mentor">
                                <div class="mentor-info">
                                    <h4>Linda Wang</h4>
                                    <p>Mandarin Language Expert</p>
                                </div>
                            </div>
                            <div class="class-footer">
                                <div class="class-price">Rp 799.000</div>
                                <button class="enroll-btn">Daftar Sekarang</button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Section -->
                    <div class="stats-section">
                        <div class="stat-card">
                            <div class="stat-number">50+</div>
                            <div class="stat-label">Kelas Tersedia</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">1,500+</div>
                            <div class="stat-label">Siswa Aktif</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">Tingkat Kepuasan</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">25+</div>
                            <div class="stat-label">Mentor Ahli</div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function filterClasses(category) {
                    const cards = document.querySelectorAll('.class-card');
                    const tabs = document.querySelectorAll('.filter-tab');

                    // Update active tab
                    tabs.forEach(tab => tab.classList.remove('active'));
                    event.target.classList.add('active');

                    // Filter cards with animation
                    cards.forEach((card, index) => {
                        if (category === 'all' || card.dataset.category === category) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0) scale(1)';
                            }, index * 50); // Staggered animation
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px) scale(0.9)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                }

                // Enhanced enroll button functionality
                document.querySelectorAll('.enroll-btn').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();

                        const originalText = this.innerHTML;

                        // Add loading animation
                        this.innerHTML = '<span style="display: inline-flex; align-items: center; gap: 8px;">Processing... <div style="width: 12px; height: 12px; border: 2px solid rgba(255,255,255,0.3); border-top: 2px solid white; border-radius: 50%; animation: spin 1s linear infinite;"></div></span>'
                        ;
                        this.style.opacity = '0.7';
                        this.disabled = true;

                        setTimeout(() => {
                            // Success state
                            this.innerHTML = 'Terdaftar ✓';
                            this.style.background = 'linear-gradient(45deg, #28a745, #20c997)';
                            this.style.opacity = '1';

                            // Show success message
                            const card = this.closest('.class-card');
                            const className = card.querySelector('.class-title').textContent;

                            // Create and show notification
                            showNotification(`Berhasil mendaftar kelas "${className}"!`);

                        }, 2000);
                    });
                });

                // Notification function
                function showNotification(message) {
                    const notification = document.createElement('div');
                    notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: linear-gradient(45deg, #28a745, #20c997);
                    color: white;
                    padding: 15px 25px;
                    border-radius: 10px;
                    box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
                    z-index: 1000;
                    transform: translateX(400px);
                    transition: all 0.3s ease;
                    max-width: 300px;
                    font-weight: 500;
                `;
                    notification.textContent = message;

                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.style.transform = 'translateX(0)';
                    }, 100);

                    setTimeout(() => {
                        notification.style.transform = 'translateX(400px)';
                        setTimeout(() => {
                            document.body.removeChild(notification);
                        }, 300);
                    }, 4000);
                }

                // Add CSS keyframes for loading spinner
                const style = document.createElement('style');
                style.textContent = `
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            `;
                document.head.appendChild(style);

                // Intersection Observer for scroll animations
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }, index * 100);
                        }
                    });
                }, observerOptions);

                // Apply scroll animations
                document.querySelectorAll('.class-card').forEach(card => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'all 0.6s ease';
                    observer.observe(card);
                });

                // Search functionality (bonus feature)
                function addSearchFeature() {
                    const searchContainer = document.createElement('div');
                    searchContainer.innerHTML = `
                    <div style="max-width: 400px; margin: 0 auto 30px auto; position: relative;">
                        <input type="text" id="classSearch" placeholder="Cari kelas..." style="
                        width: 100%;
                        padding: 15px 50px 15px 20px;
                        border: none;
                        border-radius: 25px;
                        background: rgba(255, 255, 255, 0.2);
                        color: white;
                        font-size: 16px;
                        backdrop-filter: blur(10px);
                        outline: none;
                    ">
                        <div style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.7);">🔍</div>
                    </div>
                `;

                    document.querySelector('.filter-tabs').parentNode.insertBefore(searchContainer, document.querySelector(
                        '.filter-tabs'));

                    document.getElementById('classSearch').addEventListener('input', function(e) {
                        const searchTerm = e.target.value.toLowerCase();
                        const cards = document.querySelectorAll('.class-card');

                        cards.forEach(card => {
                            const title = card.querySelector('.class-title').textContent.toLowerCase();
                            const description = card.querySelector('.class-description').textContent
                                .toLowerCase();
                            const category = card.querySelector('.class-category').textContent
                        .toLowerCase();

                            if (title.includes(searchTerm) || description.includes(searchTerm) || category
                                .includes(searchTerm)) {
                                card.style.display = 'block';
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0) scale(1)';
                            } else {
                                card.style.opacity = '0';
                                card.style.transform = 'translateY(20px) scale(0.9)';
                                setTimeout(() => {
                                    card.style.display = 'none';
                                }, 300);
                            }
                        });
                    });
                }

                // Add search feature after page loads
                setTimeout(addSearchFeature, <
                        /div>
                    @endsection
