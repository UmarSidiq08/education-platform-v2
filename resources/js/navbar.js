
    // ===================
    // CAROUSEL FUNCTIONALITY
    // ===================
    class EnhancedCarousel {
        constructor() {
            this.currentSlide = 0;
            this.totalSlides = 3;
            this.autoPlayInterval = null;
            this.autoPlayDuration = 5000;
            this.init();
        }

        init() {
            this.startAutoPlay();
            this.updateProgressBar();
            this.bindEvents();
        }

        bindEvents() {
            // Touch/swipe support
            let startX = 0;
            let endX = 0;
            const carousel = document.querySelector('.carousel-container');

            carousel.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });

            carousel.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                this.handleSwipe();
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') this.previousSlide();
                if (e.key === 'ArrowRight') this.nextSlide();
            });

            // Pause on hover
            carousel.addEventListener('mouseenter', () => this.pauseAutoPlay());
            carousel.addEventListener('mouseleave', () => this.startAutoPlay());
        }

        handleSwipe() {
            const threshold = 50;
            const diff = startX - endX;

            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    this.nextSlide();
                } else {
                    this.previousSlide();
                }
            }
        }

        goToSlide(index) {
            this.currentSlide = index;
            this.updateSlides();
            this.updateDots();
            this.updateProgressBar();
            this.restartAutoPlay();
        }

        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            this.updateSlides();
            this.updateDots();
            this.updateProgressBar();
            this.restartAutoPlay();
        }

        previousSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            this.updateSlides();
            this.updateDots();
            this.updateProgressBar();
            this.restartAutoPlay();
        }

        updateSlides() {
            const slides = document.querySelectorAll('.carousel-slide');
            slides.forEach((slide, index) => {
                slide.classList.toggle('active', index === this.currentSlide);
            });
        }

        updateDots() {
            const dots = document.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === this.currentSlide);
            });
        }

        updateProgressBar() {
            const progressBar = document.querySelector('.progress-bar');
            const width = ((this.currentSlide + 1) / this.totalSlides) * 100;
            progressBar.style.width = `${width}%`;
        }

        startAutoPlay() {
            this.pauseAutoPlay();
            this.autoPlayInterval = setInterval(() => {
                this.nextSlide();
            }, this.autoPlayDuration);
        }

        pauseAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        }

        restartAutoPlay() {
            this.startAutoPlay();
        }
    }

    // ===================
    // DROPDOWN FUNCTIONALITY
    // ===================
    function toggleDropdown() {
        const dropdown = document.querySelector('.user-dropdown');
        dropdown.classList.toggle('active');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        const dropdown = document.querySelector('.user-dropdown');
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
        }
    });

    // Handle dropdown item clicks
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const action = this.textContent.trim();

            // Close dropdown
            document.querySelector('.user-dropdown').classList.remove('active');

            // Handle different actions
            switch (action) {
                case 'Login':
                    console.log('Redirecting to login...');
                    // window.location.href = '/login';
                    break;
                case 'Sign Up':
                    console.log('Redirecting to signup...');
                    // window.location.href = '/signup';
                    break;
                case 'Log Out':
                    if (confirm('Are you sure you want to log out?')) {
                        console.log('Logging out...');
                        // Handle logout logic
                    }
                    break;
            }
        });
    });

    // ===================
    // GLOBAL FUNCTIONS
    // ===================
    let carousel;

    function changeSlide(direction) {
        if (direction === 1) {
            carousel.nextSlide();
        } else {
            carousel.previousSlide();
        }
    }

    function goToSlide(index) {
        carousel.goToSlide(index);
    }

    // ===================
    // INITIALIZATION
    // ===================
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize enhanced carousel
        carousel = new EnhancedCarousel();

        // Smooth scrolling for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced CTA button interaction
        const ctaButton = document.querySelector('.cta-button');
        if (ctaButton) {
            ctaButton.addEventListener('click', function () {
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
                    `;

                this.appendChild(ripple);
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }

        // Add scroll-based navbar styling
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(79, 195, 247, 0.95)';
                navbar.style.backdropFilter = 'blur(20px)';
            } else {
                navbar.style.background = 'linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%)';
                navbar.style.backdropFilter = 'blur(20px)';
            }
        });

        // Add intersection observer for animations
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

        // Apply observer to elements that need animation
        document.querySelectorAll('.brand-section').forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px)';
            element.style.transition = `opacity 0.8s ease ${index * 0.2}s, transform 0.8s ease ${index * 0.2}s`;
            observer.observe(element);
        });
    });

    // Add ripple animation CSS
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

