<!-- Navbar -->

<style>
    /* ===================
           RESET & BASE STYLES
           =================== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: #f8fafc;
        min-height: 100vh;
        line-height: 1.6;
    }

    /* ===================
           NAVBAR STYLES
           =================== */
    .navbar {
        background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
        padding: 1rem 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        backdrop-filter: blur(20px);
    }

    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
    }

    .nav-left {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .logo-icon {
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .logo-icon:hover {
        transform: scale(1.05);
    }

    .nav-links {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        align-items: center;
        background: rgba(255, 255, 255, 0.95);
        padding: 0.4rem;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(15px);
    }

    .nav-links li a {
        text-decoration: none;
        color: #374151;
        font-weight: 600;
        padding: 0.8rem 1.3rem;
        border-radius: 15px;
        transition: all 0.3s ease;
        position: relative;
        white-space: nowrap;
        font-size: 0.9rem;
    }

    .nav-links li a:hover {
        background: rgba(79, 195, 247, 0.15);
        color: #1976d2;
        transform: translateY(-2px);
    }

    .nav-links li a.active {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);
    }

    /* User Dropdown */
    .user-dropdown {
        position: relative;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        background: rgba(255, 255, 255, 0.95);
        padding: 0.6rem 1.2rem;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(15px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .user-info:hover {
        background: white;
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        box-shadow: 0 2px 10px rgba(79, 195, 247, 0.3);
    }

    .dropdown-arrow {
        font-size: 0.7rem;
        color: #6b7280;
        transition: transform 0.3s ease;
    }

    .user-dropdown.active .dropdown-arrow {
        transform: rotate(180deg);
    }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 15px);
        right: 0;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        min-width: 200px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-15px) scale(0.95);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .user-dropdown.active .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        color: #374151;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .dropdown-item:hover {
        background: rgba(79, 195, 247, 0.1);
        color: #1976d2;
    }

    .dropdown-item.logout:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    /* ===================
           ENHANCED CAROUSEL STYLES
           =================== */
    .carousel-wrapper {
        margin-top: 80px;
        padding: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 80vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .carousel-container {
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        position: relative;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
    }

    .carousel-bg-effects {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
    }

    .bg-particle {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
        animation: floatParticles 8s ease-in-out infinite;
    }

    .particle-1 {
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, #ff6b6b, transparent);
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }

    .particle-2 {
        width: 80px;
        height: 80px;
        background: radial-gradient(circle, #4ecdc4, transparent);
        top: 70%;
        right: 15%;
        animation-delay: -2s;
    }

    .particle-3 {
        width: 60px;
        height: 60px;
        background: radial-gradient(circle, #45b7d1, transparent);
        bottom: 20%;
        left: 20%;
        animation-delay: -4s;
    }

    .particle-4 {
        width: 120px;
        height: 120px;
        background: radial-gradient(circle, #f9ca24, transparent);
        top: 30%;
        right: 30%;
        animation-delay: -6s;
    }

    @keyframes floatParticles {

        0%,
        100% {
            transform: translate(0, 0) rotate(0deg) scale(1);
        }

        25% {
            transform: translate(20px, -20px) rotate(90deg) scale(1.1);
        }

        50% {
            transform: translate(-10px, -30px) rotate(180deg) scale(0.9);
        }

        75% {
            transform: translate(-20px, 10px) rotate(270deg) scale(1.05);
        }
    }

    .bg-gradient-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg,
                rgba(102, 126, 234, 0.9) 0%,
                rgba(118, 75, 162, 0.8) 50%,
                rgba(74, 144, 226, 0.9) 100%);
    }

    .carousel {
        position: relative;
        height: 600px;
        z-index: 2;
    }

    .carousel-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        opacity: 0;
        transform: translateX(50px) scale(0.95);
        transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        z-index: 1;
    }

    .carousel-slide.active {
        opacity: 1;
        transform: translateX(0) scale(1);
        z-index: 2;
    }

    .slide-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: -1;
    }

    .slide-bg-1 {
        background: linear-gradient(135deg, #008e37 0%, #9bfaba 100%);
    }

    .slide-bg-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .slide-bg-3 {
        background: linear-gradient(135deg, #ff0000 0%, #edc3c3 100%);
    }

    .slide-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .slide-content {
        flex: 1;
        padding: 4rem;
        max-width: 600px;
        z-index: 3;
    }

    .content-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        animation: slideInLeft 0.8s ease-out;
    }

    .slide-title {
        font-size: 3.2rem;
        color: white;
        margin-bottom: 1.5rem;
        font-weight: 800;
        line-height: 1.2;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        animation: slideInLeft 0.8s ease-out 0.2s both;
    }

    .slide-description {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2rem;
        line-height: 1.7;
        animation: slideInLeft 0.8s ease-out 0.4s both;
    }

    .slide-stats {
        display: flex;
        gap: 2rem;
        margin-bottom: 2.5rem;
        animation: slideInLeft 0.8s ease-out 0.6s both;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        color: white;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .stat-label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
    }

    .slide-cta-btn {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        backdrop-filter: blur(15px);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        animation: slideInLeft 0.8s ease-out 0.8s both;
    }

    .slide-cta-btn:hover {
        background: white;
        color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .slide-cta-btn span {
        transition: transform 0.3s ease;
    }

    .slide-cta-btn:hover span {
        transform: translateX(5px);
    }

    /* Visual Elements */
    .slide-visual {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        z-index: 3;
    }

    .visual-element {
        position: relative;
        width: 300px;
        height: 400px;
        animation: slideInRight 0.8s ease-out 0.4s both;
    }

    .soccer-player-enhanced {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .player-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulseGlow 3s ease-in-out infinite;
    }

    .player-illustration {
        width: 200px;
        height: 280px;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 280"><rect width="200" height="280" fill="transparent"/><ellipse cx="100" cy="260" rx="60" ry="15" fill="%23000" opacity="0.3"/><rect x="85" y="120" width="30" height="100" fill="%23c62828" rx="3"/><rect x="80" y="110" width="40" height="15" fill="%23fff" rx="2"/><rect x="90" y="100" width="20" height="12" fill="%23fff" rx="6"/><circle cx="100" cy="80" r="25" fill="%23d4a574"/><rect x="95" y="70" width="10" height="8" fill="%23333"/><rect x="75" y="180" width="15" height="70" fill="%23c62828"/><rect x="110" y="180" width="15" height="70" fill="%23c62828"/><rect x="70" y="240" width="25" height="8" fill="%23000"/><rect x="105" y="240" width="25" height="8" fill="%23000"/><circle cx="92" cy="75" r="2" fill="%23333"/><circle cx="108" cy="75" r="2" fill="%23333"/><path d="M95 85 Q100 90 105 85" stroke="%23333" stroke-width="1" fill="none"/></svg>') center/contain no-repeat;
        animation: playerBounce 2s ease-in-out infinite;
    }

    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
    }

    .float-icon {
        position: absolute;
        font-size: 1.5rem;
        animation: floatIcon 4s ease-in-out infinite;
    }

    .float-icon:nth-child(1) {
        top: 20%;
        right: 10%;
        animation-delay: 0s;
    }

    .float-icon:nth-child(2) {
        top: 60%;
        left: 10%;
        animation-delay: -1.5s;
    }

    .float-icon:nth-child(3) {
        bottom: 20%;
        right: 20%;
        animation-delay: -3s;
    }

    /* Enhanced Navigation */
    .carousel-navigation {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%);
        display: flex;
        justify-content: space-between;
        padding: 0 2rem;
        z-index: 4;
    }

    .nav-arrow {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        backdrop-filter: blur(15px);
    }

    .nav-arrow:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: scale(1.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .nav-arrow svg {
        width: 24px;
        height: 24px;
    }

    /* Enhanced Dots */
    .carousel-dots {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 1rem;
        z-index: 4;
    }

    .dot {
        width: 60px;
        height: 8px;
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dot:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .dot.active {
        background: rgba(255, 255, 255, 0.6);
    }

    .dot-progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: white;
        border-radius: 4px;
        width: 0;
        transition: width 0.3s ease;
    }

    .dot.active .dot-progress {
        width: 100%;
    }

    /* Progress Bar */
    .carousel-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        z-index: 4;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1);
        width: 33.33%;
        transition: width 5s linear;
    }

    /* Mentor Illustration */
    .mentor-illustration {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mentor-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(245, 87, 108, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulseGlow 3s ease-in-out infinite;
    }

    .mentor-avatar {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: white;
        box-shadow: 0 20px 40px rgba(245, 87, 108, 0.3);
        animation: mentorFloat 3s ease-in-out infinite;
    }

    .mentor-avatar::before {
        content: '👨‍🏫';
    }

    /* Trophy Illustration */
    .trophy-illustration {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .trophy-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(79, 195, 247, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulseGlow 3s ease-in-out infinite;
    }

    .trophy-icon {
        font-size: 8rem;
        animation: trophySpin 4s ease-in-out infinite;
        filter: drop-shadow(0 10px 20px rgba(255, 193, 7, 0.4));
    }

    /* Animations */
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulseGlow {

        0%,
        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.2;
        }

        50% {
            transform: translate(-50%, -50%) scale(1.1);
            opacity: 0.3;
        }
    }

    @keyframes playerBounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes floatIcon {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
            opacity: 0.7;
        }

        50% {
            transform: translateY(-20px) rotate(180deg);
            opacity: 1;
        }
    }

    @keyframes mentorFloat {

        0%,
        100% {
            transform: translateY(0) scale(1);
        }

        50% {
            transform: translateY(-15px) scale(1.05);
        }
    }

    @keyframes trophySpin {

        0%,
        100% {
            transform: rotateY(0deg) scale(1);
        }

        50% {
            transform: rotateY(180deg) scale(1.1);
        }
    }

    /* ===================
           BOTTOM SECTION STYLES
           =================== */
    .bottom-section {
        background: linear-gradient(135deg, #e8f5e8 0%, #f0f8ff 100%);
        padding: 6rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .bottom-section::before {
        content: '';
        position: absolute;
        top: -50px;
        left: 0;
        right: 0;
        height: 100px;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 100"><path d="M0,50 Q300,0 600,50 T1200,50 L1200,100 L0,100 Z" fill="%23f8fafc"/></svg>') center/cover no-repeat;
    }

    .brand-section {
        max-width: 800px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out 0.3s both;
    }

    .brand-title {
        font-size: 5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        letter-spacing: -3px;
    }

    .brand-subtitle {
        font-size: 1.4rem;
        color: #6b7280;
        margin-bottom: 3rem;
        font-weight: 500;
    }

    .cta-button {
        display: inline-block;
        background: linear-gradient(135deg, #ffa726 0%, #ff9800 100%);
        color: white;
        padding: 1.2rem 3.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.2rem;
        box-shadow: 0 15px 35px rgba(255, 152, 0, 0.3);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .cta-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .cta-button:hover::before {
        left: 100%;
    }

    .cta-button:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 45px rgba(255, 152, 0, 0.4);
        background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===================
           RESPONSIVE DESIGN
           =================== */
    @media (max-width: 1024px) {
        .slide-content {
            padding: 3rem 2rem;
        }

        .slide-title {
            font-size: 2.8rem;
        }

        .visual-element {
            width: 250px;
            height: 350px;
        }
    }

    @media (max-width: 768px) {
        .nav-links {
            display: none;
        }

        .nav-left {
            gap: 1rem;
        }

        .navbar {
            padding: 1rem;
        }

        .user-info {
            padding: 0.5rem 1rem;
        }

        .user-name {
            display: none;
        }

        .dropdown-menu {
            min-width: 160px;
        }

        .carousel-wrapper {
            padding: 1rem;
        }

        .carousel {
            height: 500px;
        }

        .carousel-slide {
            flex-direction: column;
            text-align: center;
        }

        .slide-content {
            padding: 2rem 1.5rem;
            max-width: 100%;
        }

        .slide-title {
            font-size: 2.2rem;
        }

        .slide-stats {
            justify-content: center;
        }

        .visual-element {
            width: 200px;
            height: 250px;
            margin-top: 1rem;
        }

        .nav-arrow {
            width: 50px;
            height: 50px;
        }

        .carousel-navigation {
            padding: 0 1rem;
        }

        .brand-title {
            font-size: 3rem;
        }

        .brand-subtitle {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .slide-content {
            padding: 1.5rem 1rem;
        }

        .slide-title {
            font-size: 1.8rem;
        }

        .slide-description {
            font-size: 1rem;
        }

        .brand-title {
            font-size: 2.5rem;
        }

        .cta-button {
            padding: 1rem 2.5rem;
            font-size: 1rem;
        }


    }
</style>



<script>
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
        const action = this.textContent.trim();

        // Jangan preventDefault untuk logout
        if (action !== 'Log Out' && !this.classList.contains('logout')) {
            e.preventDefault();
        }

        // Close dropdown
        document.querySelector('.user-dropdown').classList.remove('active');

        // Handle actions
        if (action === 'Log Out') {
            // Biarkan form logout berjalan normal, jangan intercept
            return true;
        }
        // ... handle actions lainnya
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
</script>
@yield('content')
</body>
