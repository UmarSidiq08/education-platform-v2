<!-- Navbar -->
@extends('layouts.app')

@section('content')
    <!-- Enhanced Carousel Section -->
    @include('layout.template')
    @include('layout.carousel')

    <script src="#carousel-scripts"></script>
    <script src="#main-scripts"></script>


    <!-- Footer Section -->
    <footer class="footer-section">
        <!-- Wave decoration -->
        <div class="footer-wave">
            <svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,50 Q300,0 600,50 T1200,50 L1200,120 L0,120 Z" fill="currentColor" />
            </svg>
        </div>

        <div class="footer-content">
@include('layout.footer')

    <style>
        /* ===================
               FOOTER STYLES
               =================== */
        .footer-section {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            position: relative;
            overflow: hidden;
            margin-top: 4rem;
        }

        .footer-wave {
            position: absolute;
            top: -60px;
            left: 0;
            right: 0;
            height: 60px;
            color: #f8fafc;
            z-index: 1;
        }

        .footer-wave svg {
            width: 100%;
            height: 100%;
        }

        .footer-content {
            position: relative;
            z-index: 2;
            padding-top: 4rem;
        }

        .footer-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem 3rem;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1.5fr;
            gap: 3rem;
        }

        .footer-column {
            animation: fadeInUp 0.8s ease-out;
        }

        .footer-column:nth-child(1) {
            animation-delay: 0.1s;
        }

        .footer-column:nth-child(2) {
            animation-delay: 0.2s;
        }

        .footer-column:nth-child(3) {
            animation-delay: 0.3s;
        }

        .footer-column:nth-child(4) {
            animation-delay: 0.4s;
        }

        .footer-column:nth-child(5) {
            animation-delay: 0.5s;
        }

        /* Company Info */
        .company-info .footer-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .company-info .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 8px 25px rgba(79, 195, 247, 0.3);
        }

        .company-info h3 {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .company-description {
            color: #b0b7c3;
            line-height: 1.7;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .social-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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
            gap: 0.8rem;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
        }

        .column-title i {
            width: 20px;
            color: #4fc3f7;
        }

        /* Footer Links */
        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #b0b7c3;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 1rem;
        }

        .footer-links a::before {
            content: '→';
            position: absolute;
            left: 0;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
            color: #4fc3f7;
        }

        .footer-links a:hover {
            color: #4fc3f7;
            padding-left: 1.5rem;
        }

        .footer-links a:hover::before {
            opacity: 1;
            transform: translateX(0);
        }

        /* Contact Info */
        .contact-info .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(5px);
        }

        .contact-item i {
            color: #4fc3f7;
            font-size: 1.1rem;
            width: 20px;
            margin-top: 2px;
        }

        .contact-item div {
            flex: 1;
        }

        .contact-label {
            display: block;
            font-size: 0.85rem;
            color: #8892a0;
            margin-bottom: 2px;
        }

        .contact-value {
            display: block;
            color: white;
            font-weight: 600;
        }

        /* Newsletter Section */
        .newsletter-section {
            background: linear-gradient(135deg, rgba(79, 195, 247, 0.1) 0%, rgba(41, 182, 246, 0.1) 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 3rem 0;
            margin: 0 0 2rem;
        }

        .newsletter-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 3rem;
            align-items: center;
        }

        .newsletter-text h4 {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }

        .newsletter-text h4 i {
            color: #4fc3f7;
        }

        .newsletter-text p {
            color: #b0b7c3;
            line-height: 1.6;
        }

        .newsletter-form {
            max-width: 500px;
        }

        .input-group {
            display: flex;
            gap: 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 4px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 1rem;
        }

        .input-group input {
            flex: 1;
            background: none;
            border: none;
            padding: 1rem;
            color: white;
            font-size: 0.95rem;
            border-radius: 8px;
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
            padding: 1rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .input-group button:hover {
            background: linear-gradient(135deg, #29b6f6 0%, #1976d2 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 195, 247, 0.4);
        }

        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            color: #b0b7c3;
            font-size: 0.85rem;
            line-height: 1.5;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-container input {
            display: none;
        }

        .checkmark {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .checkbox-container input:checked+.checkmark {
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            border-color: #4fc3f7;
        }

        .checkbox-container input:checked+.checkmark::after {
            content: '✓';
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .checkbox-container a {
            color: #4fc3f7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .checkbox-container a:hover {
            color: #29b6f6;
            text-decoration: underline;
        }

        /* App Download Section */
        .app-download-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            margin: 0 2rem 3rem;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .app-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            align-items: center;
        }

        .app-text h4 {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }

        .app-text h4 i {
            color: #4fc3f7;
        }

        .app-text p {
            color: #b0b7c3;
            line-height: 1.6;
        }

        .download-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .download-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .download-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .download-btn i {
            font-size: 1.8rem;
            color: #4fc3f7;
        }

        .download-btn div span {
            display: block;
            font-size: 0.8rem;
            color: #b0b7c3;
        }

        .download-btn div strong {
            display: block;
            font-size: 1rem;
            font-weight: 600;
        }

        /* Footer Bottom */
        .footer-bottom {
            background: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem 0;
        }

        .bottom-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .bottom-left p {
            color: #8892a0;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .legal-links {
            display: flex;
            gap: 1.5rem;
        }

        .legal-links a {
            color: #b0b7c3;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .legal-links a:hover {
            color: #4fc3f7;
        }

        .bottom-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .language-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .language-selector i {
            color: #4fc3f7;
        }

        .language-selector select {
            background: none;
            border: none;
            color: white;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .language-selector select option {
            background: #1a1a2e;
            color: white;
        }

        .back-to-top {
            width: 45px;
            height: 45px;
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
            box-shadow: 0 8px 25px rgba(79, 195, 247, 0.4);
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

        .footer-bg-effects .bg-particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.03;
            animation: floatParticles 12s ease-in-out infinite;
        }

        .footer-bg-effects .particle-1 {
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, #4fc3f7, transparent);
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .footer-bg-effects .particle-2 {
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, #29b6f6, transparent);
            top: 60%;
            right: 20%;
            animation-delay: -4s;
        }

        .footer-bg-effects .particle-3 {
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, #4fc3f7, transparent);
            bottom: 30%;
            left: 60%;
            animation-delay: -8s;
        }

        .footer-bg-effects .particle-4 {
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, #29b6f6, transparent);
            top: 40%;
            right: 50%;
            animation-delay: -12s;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatParticles {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg) scale(1);
            }

            25% {
                transform: translate(30px, -30px) rotate(90deg) scale(1.1);
            }

            50% {
                transform: translate(-20px, -50px) rotate(180deg) scale(0.9);
            }

            75% {
                transform: translate(-30px, 20px) rotate(270deg) scale(1.05);
            }
        }

        /* ===================
               RESPONSIVE DESIGN
               =================== */
        @media (max-width: 1200px) {
            .footer-main {
                grid-template-columns: 2fr 1fr 1fr 1.2fr;
                gap: 2rem;
            }

            .newsletter-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
            }

            .app-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                text-align: center;
            }

            .download-buttons {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .footer-main {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 0 1rem 2rem;
            }

            .newsletter-content,
            .app-content {
                padding: 0 1rem;
            }

            .app-download-section {
                margin: 0 1rem 2rem;
            }

            .download-buttons {
                flex-direction: column;
                align-items: center;
            }

            .download-btn {
                width: 100%;
                max-width: 250px;
                justify-content: center;
            }

            .bottom-content {
                flex-direction: column;
                text-align: center;
                padding: 0 1rem;
            }

            .legal-links {
                justify-content: center;
                flex-wrap: wrap;
            }

            .social-links {
                justify-content: center;
            }

            .newsletter-form {
                max-width: 100%;
            }

            .input-group {
                flex-direction: column;
                gap: 0.5rem;
            }

            .input-group button {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .footer-content {
                padding-top: 2rem;
            }

            .company-info .footer-logo {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .social-links {
                gap: 0.5rem;
            }

            .social-link {
                width: 40px;
                height: 40px;
            }

            .contact-item {
                padding: 0.8rem;
            }

            .newsletter-section,
            .app-download-section {
                padding: 2rem 0;
            }

            .column-title {
                font-size: 1.1rem;
            }

            .download-btn {
                padding: 0.8rem 1rem;
            }
        }
    </style>

    <script>
        // ===================
        // FOOTER FUNCTIONALITY
        // ===================

        // Back to top functionality
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Newsletter form submission
        document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = this.querySelector('input[type="email"]').value;
            const checkbox = this.querySelector('input[type="checkbox"]').checked;

            if (!checkbox) {
                alert('Mohon setujui kebijakan privasi dan syarat ketentuan terlebih dahulu.');
                return;
            }

            // Show loading state
            const button = this.querySelector('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
            button.disabled = true;

            // Simulate API call
            setTimeout(() => {
                alert('Terima kasih! Anda telah berhasil berlangganan newsletter kami.');
                this.reset();
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        });

        // Social media link tracking
        document.querySelectorAll('.social-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const platform = this.getAttribute('data-platform');
                console.log(`Redirecting to ${platform}...`);

                // Add ripple effect
                const ripple = document.createElement('div');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255,255,255,0.6);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    left: 50%;
                    top: 50%;
                    width: 20px;
                    height: 20px;
                    margin-left: -10px;
                    margin-top: -10px;
                    pointer-events: none;
                `;

                this.style.position = 'relative';
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                    // Here you would redirect to actual social media pages
                    // window.open(`https://${platform}.com/edubuddy`, '_blank');
                }, 600);
            });
        });

        // Download button tracking
        document.querySelectorAll('.download-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const store = this.querySelector('strong').textContent;
                console.log(`Redirecting to ${store}...`);

                // Add download animation
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                    // Here you would redirect to actual app stores
                }, 150);
            });
        });

        // Language selector functionality
        document.querySelector('.language-selector select').addEventListener('change', function() {
            const selectedLang = this.value;
            console.log(`Language changed to: ${selectedLang}`);

            // Here you would implement actual language switching
            if (selectedLang === 'en') {
                // Switch to English
                console.log('Switching to English...');
            } else {
                // Switch to Indonesian
                console.log('Switching to Indonesian...');
            }
        });

        // Intersection Observer for animations
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Apply observer to footer columns
            document.querySelectorAll('.footer-column').forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition =
                    `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(element);
            });

            // Apply observer to newsletter and app sections
            ['.newsletter-section', '.app-download-section'].forEach(selector => {
                const element = document.querySelector(selector);
                if (element) {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(30px)';
                    element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                    observer.observe(element);
                }
            });
        });

        // Add floating particles interaction
        document.querySelectorAll('.bg-particle').forEach(particle => {
            particle.addEventListener('mouseenter', function() {
                this.style.animationPlayState = 'paused';
                this.style.transform += ' scale(1.2)';
                this.style.opacity = '0.1';
            });

            particle.addEventListener('mouseleave', function() {
                this.style.animationPlayState = 'running';
                this.style.transform = this.style.transform.replace(' scale(1.2)', '');
                this.style.opacity = '0.03';
            });
        });

        // Smooth scrolling for footer links
        document.querySelectorAll('.footer-links a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                } else {
                    console.log(`Target element #${targetId} not found`);
                }
            });
        });

        // Add ripple animation for buttons
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Show/hide back to top button based on scroll
        window.addEventListener('scroll', function() {
            const backToTop = document.querySelector('.back-to-top');
            if (window.scrollY > 300) {
                backToTop.style.opacity = '1';
                backToTop.style.visibility = 'visible';
                backToTop.style.transform = 'scale(1)';
            } else {
                backToTop.style.opacity = '0';
                backToTop.style.visibility = 'hidden';
                backToTop.style.transform = 'scale(0.8)';
            }
        });

        // Add hover effects for contact items
        document.querySelectorAll('.contact-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.background = 'rgba(79, 195, 247, 0.1)';
                this.style.borderColor = 'rgba(79, 195, 247, 0.3)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.background = 'rgba(255, 255, 255, 0.05)';
                this.style.borderColor = 'rgba(255, 255, 255, 0.1)';
            });
        });

        // Footer link click tracking
        document.querySelectorAll('.footer-links a').forEach(link => {
            link.addEventListener('click', function(e) {
                const linkText = this.textContent.trim();
                const section = this.closest('.footer-column').querySelector('.column-title').textContent
                    .trim();
                console.log(`Footer link clicked: ${linkText} in ${section} section`);
            });
        });

        // Contact info click handlers
        document.querySelectorAll('.contact-item').forEach(item => {
            item.addEventListener('click', function() {
                const label = this.querySelector('.contact-label').textContent;
                const value = this.querySelector('.contact-value').textContent;

                if (label === 'Telepon') {
                    window.open(`tel:${value.replace(/\s/g, '')}`, '_self');
                } else if (label === 'Email') {
                    window.open(`mailto:${value}`, '_self');
                } else if (label === 'Alamat') {
                    window.open(`https://maps.google.com/?q=${encodeURIComponent(value)}`, '_blank');
                }
            });
        });
    </script>
@endsection

{{--
 <h1>Dashboard</h1>
<p>Selamat datang, {{ $user->name }}!</p>

@if ($user->hasRole('mentor'))
    <a>Tambah Materi</a>
@endif --}}
