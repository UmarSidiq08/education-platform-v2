<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduBuddy Footer</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>


<body>

    <!-- Footer Section -->
    <footer class="footer-section">

        <div class="footer-content">
            <!-- Main Footer Grid -->
            <div class="footer-main">
                <!-- Company Info Column -->
                <div class="footer-column company-info">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3>EduBuddy</h3>
                    </div>
                    <p class="company-description">
                        Teman setia waktu kamu belajar. Bergabunglah dengan ribuan siswa yang telah merasakan pengalaman
                        belajar yang luar biasa bersama kami.
                    </p>

                    <div class="social-links">
                        <a href="#" class="social-link facebook" data-platform="facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link twitter" data-platform="twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link instagram" data-platform="instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link youtube" data-platform="youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-link linkedin" data-platform="linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links Column -->
                <div class="footer-column">
                    <h4 class="column-title">
                        <i class="fas fa-link"></i>
                        Quick Links
                    </h4>
                    <ul class="footer-links">
                        <li><a href="#about">Tentang Kami</a></li>
                        <li><a href="#courses">Kursus</a></li>
                        <li><a href="#mentors">Mentor</a></li>
                        <li><a href="#pricing">Harga</a></li>
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#career">Karir</a></li>
                    </ul>
                </div>

                <!-- Programs Column -->
                <div class="footer-column">
                    <h4 class="column-title">
                        <i class="fas fa-code"></i>
                        Program
                    </h4>
                    <ul class="footer-links">
                        <li><a href="#web-dev">Web Development</a></li>
                        <li><a href="#mobile-dev">Mobile Development</a></li>
                        <li><a href="#data-science">Data Science</a></li>
                        <li><a href="#ui-ux">UI/UX Design</a></li>
                        <li><a href="#digital-marketing">Digital Marketing</a></li>
                        <li><a href="#cyber-security">Cyber Security</a></li>
                    </ul>
                </div>

                <!-- Contact Info Column -->
                <div class="footer-column">
                    <h4 class="column-title">
                        <i class="fas fa-phone"></i>
                        Kontak
                    </h4>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <span class="contact-label">Email</span>
                                <span class="contact-value">info@edubuddy.id</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <span class="contact-label">Telepon</span>
                                <span class="contact-value">+62 21 1234 5678</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span class="contact-label">Alamat</span>
                                <span class="contact-value">Jakarta, Indonesia</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Newsletter Column -->
                <div class="footer-column newsletter-column">
                    <h4 class="column-title">
                        <i class="fas fa-bell"></i>
                        Newsletter
                    </h4>
                    <p class="newsletter-desc">
                        Dapatkan tips belajar dan update terbaru langsung ke email kamu.
                    </p>
                    <form class="newsletter-form">
                        <div class="input-group">
                            <input type="email" placeholder="Email kamu..." required>
                            <button type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <label class="checkbox-container">
                            <input type="checkbox" required>
                            <span class="checkmark"></span>
                            <span class="checkbox-text">Saya setuju dengan <a href="#privacy">kebijakan
                                    privasi</a></span>
                        </label>
                    </form>

                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="bottom-content">
                    <div class="bottom-left">
                        <p>&copy; 2025 Gletzer Julio Ivanees & Umar Sidiq. All rights reserved.</p>
                        <div class="legal-links">
                            <a href="#privacy">Privacy Policy</a>
                            <a href="#terms">Terms of Service</a>
                            <a href="#cookies">Cookie Policy</a>
                        </div>
                    </div>
                    <div class="bottom-right">
                        <div class="language-selector">
                            <i class="fas fa-globe"></i>
                            <select>
                                <option value="id">Bahasa Indonesia</option>
                                <option value="en">English</option>
                            </select>
                        </div>
                        <div class="back-to-top" onclick="scrollToTop()">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Effects -->
        <div class="footer-bg-effects">
            <div class="bg-particle particle-1"></div>
            <div class="bg-particle particle-2"></div>
            <div class="bg-particle particle-3"></div>
        </div>
    </footer>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }

        /* ===================
           FOOTER STYLES
           =================== */
        .footer-section {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f172a 100%);
            color: white;
            position: relative;
            overflow: hidden;
            margin-top: 0;
        }


        .footer-content {
            position: relative;
            z-index: 2;
            padding-top: 3rem;
        }

        .footer-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem 2rem;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr 1.2fr;
            gap: 2rem;
            align-items: start;
        }


        /* Company Info */
        .company-info .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 8px 25px rgba(79, 195, 247, 0.3);
        }

        .company-info h3 {
            font-size: 1.6rem;
            font-weight: 800;
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .company-description {
            color: #cbd5e1;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .social-links {
            display: flex;
            gap: 0.8rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .social-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .social-link[data-platform="facebook"]:hover {
            background: #3b5998;
            border-color: #3b5998;
        }

        .social-link[data-platform="twitter"]:hover {
            background: #1da1f2;
            border-color: #1da1f2;
        }

        .social-link[data-platform="instagram"]:hover {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            border-color: #e6683c;
        }

        .social-link[data-platform="youtube"]:hover {
            background: #ff0000;
            border-color: #ff0000;
        }

        .social-link[data-platform="linkedin"]:hover {
            background: #0077b5;
            border-color: #0077b5;
        }

        /* Column Titles */
        .column-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            color: white;
        }

        .column-title i {
            width: 18px;
            color: #4fc3f7;
        }

        /* Footer Links */
        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.6rem;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 0.8rem;
        }

        .footer-links a::before {
            content: '→';
            position: absolute;
            left: 0;
            opacity: 0;
            transform: translateX(-8px);
            transition: all 0.3s ease;
            color: #4fc3f7;
            font-size: 0.8rem;
        }

        .footer-links a:hover {
            color: #4fc3f7;
            padding-left: 1.2rem;
        }

        .footer-links a:hover::before {
            opacity: 1;
            transform: translateX(0);
        }

        /* Contact Info */
        .contact-info .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            margin-bottom: 1rem;
            padding: 0.8rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
        }

        .contact-item i {
            color: #4fc3f7;
            font-size: 1rem;
            width: 16px;
            margin-top: 2px;
        }

        .contact-item div {
            flex: 1;
        }

        .contact-label {
            display: block;
            font-size: 0.75rem;
            color: #94a3b8;
            margin-bottom: 2px;
            font-weight: 500;
        }

        .contact-value {
            display: block;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Newsletter Column */
        .newsletter-column {
            background: rgba(255, 255, 255, 0.03);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .newsletter-desc {
            color: #cbd5e1;
            font-size: 0.85rem;
            line-height: 1.5;
            margin-bottom: 1.2rem;
        }

        .newsletter-form {
            margin-bottom: 1.5rem;
        }

        .input-group {
            display: flex;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 3px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 0.8rem;
        }

        .input-group input {
            flex: 1;
            background: none;
            border: none;
            padding: 0.8rem;
            color: white;
            font-size: 0.85rem;
            border-radius: 7px;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .input-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.05);
        }

        .input-group button {
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 7px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
        }

        .input-group button:hover {
            background: linear-gradient(135deg, #29b6f6 0%, #1976d2 100%);
            transform: scale(1.05);
        }

        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            color: #cbd5e1;
            font-size: 0.75rem;
            line-height: 1.4;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-container input {
            display: none;
        }

        .checkmark {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .checkbox-container input:checked+.checkmark {
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            border-color: #4fc3f7;
        }

        .checkbox-container input:checked+.checkmark::after {
            content: '✓';
            color: white;
            font-size: 10px;
            font-weight: bold;
        }

        .checkbox-text a {
            color: #4fc3f7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .checkbox-text a:hover {
            color: #29b6f6;
            text-decoration: underline;
        }

        /* Download Section */
        .download-section {
            margin-top: 1.5rem;
        }

        .download-title {
            color: #cbd5e1;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
        }

        .download-buttons {
            display: flex;
            gap: 0.6rem;
        }

        .download-btn {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            color: #4fc3f7;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .download-btn:hover {
            background: rgba(79, 195, 247, 0.15);
            transform: translateY(-2px);
            color: white;
        }

        /* Footer Bottom */
        .footer-bottom {
            background: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem 0;
            margin-top: 1rem;
        }

        .bottom-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .bottom-left p {
            color: #94a3b8;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
        }

        .legal-links {
            display: flex;
            gap: 1.2rem;
            flex-wrap: wrap;
        }

        .legal-links a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.8rem;
            transition: color 0.3s ease;
        }

        .legal-links a:hover {
            color: #4fc3f7;
        }

        .bottom-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .language-selector {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .language-selector i {
            color: #4fc3f7;
            font-size: 0.9rem;
        }

        .language-selector select {
            background: none;
            border: none;
            color: white;
            font-size: 0.8rem;
            cursor: pointer;
            padding: 0;
        }

        .language-selector select option {
            background: #1a1a2e;
            color: white;
        }

        .back-to-top {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 195, 247, 0.3);
        }

        .back-to-top:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 6px 20px rgba(79, 195, 247, 0.4);
        }

        /* Background Effects */
        .footer-bg-effects {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            z-index: 1;
        }

        .bg-particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.04;
            animation: floatParticles 15s ease-in-out infinite;
        }

        .particle-1 {
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, #4fc3f7, transparent);
            top: 15%;
            left: 15%;
            animation-delay: 0s;
        }

        .particle-2 {
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, #29b6f6, transparent);
            top: 60%;
            right: 25%;
            animation-delay: -5s;
        }

        .particle-3 {
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, #4fc3f7, transparent);
            bottom: 25%;
            left: 70%;
            animation-delay: -10s;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatParticles {

            0%,
            100% {
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

        /* ===================
           RESPONSIVE DESIGN
           =================== */
        @media (max-width: 1024px) {
            .footer-main {
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }

            .company-info {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .footer-main {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 0 1rem 1.5rem;
            }

            .footer-content {
                padding-top: 2rem;
            }

            .bottom-content {
                flex-direction: column;
                text-align: center;
                gap: 0.8rem;
            }

            .legal-links {
                justify-content: center;
            }

            .newsletter-column {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .footer-main {
                padding: 0 0.8rem 1rem;
            }

            .social-links {
                justify-content: center;
            }

            .download-buttons {
                justify-content: center;
            }

            .input-group {
                flex-direction: column;
                gap: 0.5rem;
            }

            .input-group button {
                width: 100%;
            }
        }
    </style>

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
