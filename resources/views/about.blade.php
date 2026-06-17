@extends('layouts.app')

@section('title', 'Managee - Tentang Kami')

@section('content')
<!-- Custom About Us Styles -->
<style>
    :root {
        --emerald-primary: #1A3C34;
        --emerald-light: #2D6A4F;
        --emerald-dark: #0D221D;
        --secondary-gold: #CA8A04;
        --secondary-gold-light: #EAB308;
        --text-dark: #1E293B;
        --text-slate: #475569;
        --text-light-slate: #64748B;
        --border-color: #E2E8F0;
        --card-bg: #FFFFFF;
        --bg-light-gray: #F8FAFC;
    }

    .about-page-container {
        padding-top: 80px; /* Offset for fixed navbar */
        background-color: var(--bg-light-gray);
        font-family: 'Outfit', sans-serif;
    }

    /* Hero Banner Section (Mockup 1 Styled) */
    .about-hero {
        background-color: var(--emerald-primary);
        color: #FFFFFF;
        padding: 5rem 1.5rem 6rem 1.5rem;
        position: relative;
        overflow: hidden;
        text-align: left;
    }

    .about-hero-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 3rem;
    }

    .about-hero-content {
        flex: 1;
        max-width: 650px;
        z-index: 2;
    }

    .about-hero-tag {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--secondary-gold-light);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 1rem;
    }

    .about-hero-title {
        color: #FFFFFF; /* Force white text over dark background */
        font-size: 2.75rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        font-family: 'Outfit', sans-serif;
    }

    .about-hero-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.6;
        margin-bottom: 0px;
    }

    .about-hero-illustration {
        flex: 1;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        z-index: 2;
    }

    .about-hero-illustration svg {
        width: 100%;
        max-width: 380px;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.15));
    }

    /* Wave Curve Bottom Divider */
    .about-hero-divider {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .about-hero-divider svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 40px;
        transform: rotateY(180deg);
    }

    .about-hero-divider .shape-fill {
        fill: var(--bg-light-gray);
    }

    /* Section Wrapper */
    .about-section {
        padding: 4rem 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Carousel / Slider Section (Opsi 1) */
    .carousel-section {
        margin-top: -3.5rem; /* Make it overlay hero section slightly */
        position: relative;
        z-index: 10;
        margin-bottom: 4rem;
    }

    .carousel-container {
        position: relative;
        width: 100%;
        height: 480px; /* Enhanced height for stunning display */
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        background-color: #E2E8F0;
    }

    .carousel-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.8s ease-in-out, visibility 0.8s ease-in-out;
    }

    .carousel-slide.active {
        opacity: 1;
        visibility: visible;
    }

    .carousel-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.85);
    }

    .carousel-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 3rem 2.5rem 2.5rem 2.5rem;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.75));
        color: #FFFFFF;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .carousel-caption h3 {
        color: #FFFFFF;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .carousel-caption p {
        font-size: 0.95rem;
        opacity: 0.9;
        max-width: 600px;
        line-height: 1.4;
    }

    /* Carousel Nav Buttons */
    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--emerald-primary);
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        z-index: 15;
    }

    .carousel-btn:hover {
        background-color: #FFFFFF;
        color: var(--emerald-light);
        transform: translateY(-50%) scale(1.08);
    }

    .carousel-btn-prev { left: 1.5rem; }
    .carousel-btn-next { right: 1.5rem; }

    /* Carousel Dots Indicator */
    .carousel-dots {
        position: absolute;
        bottom: 1.5rem;
        right: 2.5rem;
        display: flex;
        gap: 0.5rem;
        z-index: 15;
    }

    .carousel-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.4);
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .carousel-dot.active {
        background-color: #FFFFFF;
        width: 28px;
        border-radius: 5px;
    }

    /* Misi, Stats, and Keunggulan Section */
    .mission-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        margin-bottom: 5rem;
        align-items: flex-start;
    }

    /* Left side (Misi & Stats) */
    .mission-left {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .section-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--secondary-gold);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 0.75rem;
    }

    .mission-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--emerald-primary);
        line-height: 1.3;
        margin-bottom: 1.5rem;
    }

    .mission-text {
        font-size: 1rem;
        color: var(--text-slate);
        line-height: 1.6;
        margin-bottom: 2.5rem;
    }

    /* Stats row */
    .stats-row {
        display: flex;
        gap: 3rem;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--secondary-gold);
        line-height: 1.1;
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--text-light-slate);
        font-weight: 600;
        margin-top: 0.25rem;
    }

    /* Right side (Keunggulan Cards 2x2 grid) */
    .features-card-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .feature-about-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        padding: 1.75rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .feature-about-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.05);
        border-color: rgba(45, 106, 79, 0.15);
    }

    .feature-icon-container {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background-color: rgba(45, 106, 79, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--emerald-light);
        margin-bottom: 1.25rem;
        transition: all 0.3s ease;
    }

    .feature-about-card:hover .feature-icon-container {
        background-color: var(--emerald-primary);
        color: #FFFFFF;
    }

    .feature-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin-bottom: 0.5rem;
    }

    .feature-card-desc {
        font-size: 0.85rem;
        color: var(--text-slate);
        line-height: 1.5;
    }

    /* Gallery Section */
    .gallery-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
    }

    .gallery-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--emerald-primary);
    }

    .gallery-desc {
        font-size: 0.95rem;
        color: var(--text-slate);
        max-width: 550px;
        line-height: 1.5;
        margin: 0;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 4rem;
    }

    .gallery-item {
        position: relative;
        height: 280px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        cursor: pointer;
    }

    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-item:hover .gallery-img {
        transform: scale(1.05);
    }

    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.5rem;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-overlay h4 {
        color: #FFFFFF;
        font-size: 1.15rem;
        margin-bottom: 0.25rem;
    }

    .gallery-overlay p {
        color: rgba(255,255,255,0.8);
        font-size: 0.8rem;
        margin: 0;
    }

    /* Call to Action (CTA) Section */
    .about-cta-container {
        max-width: 1200px;
        margin: 0 auto 2rem auto;
        padding: 0 1.5rem;
    }

    .about-cta-card {
        background: linear-gradient(135deg, var(--emerald-primary) 0%, var(--emerald-dark) 100%);
        border-radius: 20px;
        padding: 4rem 3rem;
        text-align: center;
        color: #FFFFFF;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(26, 60, 52, 0.15);
    }

    .about-cta-card::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(45, 106, 79, 0.08) 0%, transparent 60%);
        pointer-events: none;
    }

    .about-cta-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--secondary-gold-light);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 1rem;
    }

    .about-cta-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #FFFFFF;
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .about-cta-desc {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.8);
        max-width: 500px;
        margin: 0 auto 2rem auto;
        line-height: 1.5;
    }

    .btn-cta-gold {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: var(--secondary-gold);
        color: #FFFFFF;
        padding: 0.85rem 2rem;
        border-radius: var(--radius-md);
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(202, 138, 4, 0.3);
    }

    .btn-cta-gold:hover {
        background-color: var(--secondary-gold-light);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(202, 138, 4, 0.4);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .about-hero-container {
            flex-direction: column;
            text-align: center;
            gap: 2rem;
        }
        .about-hero-content {
            max-width: 100%;
        }
        .about-hero-illustration {
            justify-content: center;
        }
        .carousel-container {
            height: 350px;
        }
        .mission-grid {
            grid-template-columns: 1fr;
            gap: 3rem;
        }
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .about-hero-title {
            font-size: 2rem;
        }
        .carousel-container {
            height: 260px;
        }
        .carousel-btn {
            width: 38px;
            height: 38px;
        }
        .carousel-caption {
            padding: 1.5rem;
        }
        .carousel-caption h3 {
            font-size: 1.15rem;
        }
        .carousel-caption p {
            font-size: 0.8rem;
        }
        .features-card-grid {
            grid-template-columns: 1fr;
        }
        .stats-row {
            justify-content: space-between;
            gap: 1.5rem;
        }
        .stat-number {
            font-size: 2rem;
        }
        .gallery-grid {
            grid-template-columns: 1fr;
        }
        .gallery-item {
            height: 220px;
        }
        .about-cta-card {
            padding: 2.5rem 1.5rem;
        }
        .about-cta-title {
            font-size: 1.75rem;
        }
    }
</style>

<div class="about-page-container">

    <!-- HERO BANNER SECTION -->
    <section class="about-hero">
        <div class="about-hero-container">
            <div class="about-hero-content">
                <span class="about-hero-tag">Managee Platform</span>
                <h1 class="about-hero-title">Aplikasi Penyewaan & Pengelolaan Properti No. 1 di Bali</h1>
                <p class="about-hero-subtitle">
                    Kami hadir untuk menjembatani pemilik properti dan penyewa lewat solusi digital yang praktis, aman, dan sepenuhnya terpercaya. Mulai petualangan Anda hari ini.
                </p>
            </div>
            
            <div class="about-hero-illustration">
                <!-- Clean Modern Building Outline Vector SVG -->
                <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="80" y="40" width="120" height="220" rx="8" fill="rgba(255,255,255,0.08)" stroke="#FFFFFF" stroke-width="4" />
                    <rect x="220" y="90" width="100" height="170" rx="8" fill="rgba(255,255,255,0.12)" stroke="#FFFFFF" stroke-width="4" />
                    
                    <!-- Windows Building 1 -->
                    <rect x="105" y="75" width="25" height="25" rx="3" fill="#FFFFFF" opacity="0.9" />
                    <rect x="150" y="75" width="25" height="25" rx="3" fill="#FFFFFF" opacity="0.9" />
                    <rect x="105" y="125" width="25" height="25" rx="3" fill="none" stroke="#FFFFFF" stroke-width="3" />
                    <rect x="150" y="125" width="25" height="25" rx="3" fill="#FFFFFF" opacity="0.9" />
                    <rect x="105" y="175" width="25" height="25" rx="3" fill="#FFFFFF" opacity="0.9" />
                    <rect x="150" y="175" width="25" height="25" rx="3" fill="none" stroke="#FFFFFF" stroke-width="3" />
                    
                    <!-- Windows Building 2 -->
                    <rect x="240" y="120" width="20" height="20" rx="2" fill="#FFFFFF" opacity="0.9" />
                    <rect x="280" y="120" width="20" height="20" rx="2" fill="none" stroke="#FFFFFF" stroke-width="3" />
                    <rect x="240" y="160" width="20" height="20" rx="2" fill="#FFFFFF" opacity="0.9" />
                    <rect x="280" y="160" width="20" height="20" rx="2" fill="#FFFFFF" opacity="0.9" />
                    <rect x="240" y="200" width="20" height="20" rx="2" fill="none" stroke="#FFFFFF" stroke-width="3" />
                    <rect x="280" y="200" width="20" height="20" rx="2" fill="#FFFFFF" opacity="0.9" />
                    
                    <!-- Roof decorations -->
                    <path d="M70 45L140 10L210 45" stroke="var(--secondary-gold-light)" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M210 95L270 65L330 95" stroke="var(--secondary-gold-light)" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                    
                    <!-- Base Foundation Line -->
                    <line x1="40" y1="260" x2="360" y2="260" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round" />
                </svg>
            </div>
        </div>

        <!-- Curved SVG Wave Divider -->
        <div class="about-hero-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C26.9,8.75,57.05,18.3,84.75,25.43,158.3,44.47,238.16,68.49,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- INTERACTIVE CAROUSEL SECTION (Opsi 1) -->
    <div class="container carousel-section">
        <div class="carousel-container">
            <!-- Slide 1 -->
            <div class="carousel-slide active">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&q=80&w=1200" alt="Resort Kolam Bali" class="carousel-image">
                <div class="carousel-caption">
                    <h3>Apartemen & Resort Premium di Seminyak</h3>
                    <p>Temukan ketenangan menginap dengan fasilitas kolam renang infinity dan akses langsung ke pantai pasir putih Seminyak yang eksotis.</p>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="carousel-slide">
                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=1200" alt="Interior Apartemen" class="carousel-image">
                <div class="carousel-caption">
                    <h3>Desain Interior Modern & Minimalis</h3>
                    <p>Setiap properti kami dikurasi dengan standar kenyamanan tinggi, perabotan modern lengkap, serta kebersihan unit yang terjamin.</p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-slide">
                <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&q=80&w=1200" alt="Villa Ubud" class="carousel-image">
                <div class="carousel-caption">
                    <h3>Villa & Tempat Tinggal Asri di Ubud</h3>
                    <p>Rasakan pengalaman menyatu dengan alam tropis yang tenang dan sawah hijau Ubud untuk menyegarkan pikiran Anda.</p>
                </div>
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-btn carousel-btn-prev" onclick="moveSlide(-1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button class="carousel-btn carousel-btn-next" onclick="moveSlide(1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>

            <!-- Carousel Dots Indicators -->
            <div class="carousel-dots">
                <button class="carousel-dot active" onclick="setSlide(0)"></button>
                <button class="carousel-dot" onclick="setSlide(1)"></button>
                <button class="carousel-dot" onclick="setSlide(2)"></button>
            </div>
        </div>
    </div>

    <!-- MISSION & VALUE GRID SECTION (Hybrid Mock-up 1 & 2) -->
    <section class="about-section">
        <div class="mission-grid">
            
            <!-- Left Column: Mission text & Counters -->
            <div class="mission-left">
                <span class="section-label">Misi Kami</span>
                <h2 class="mission-title">Managee Berdedikasi Menyediakan Pilihan Properti Berkualitas Tinggi dengan Mudah</h2>
                <p class="mission-text">
                    Kami terus berinovasi untuk memberikan pengalaman sewa-menyewa properti terbaik. Memanfaatkan teknologi modern, kami menyederhanakan proses pencarian, pembayaran, dan pelaporan agar penyewa maupun pemilik merasakan transparansi penuh.
                </p>
                
                <!-- Stat counters -->
                <div class="stats-row">
                    <div class="stat-item">
                        <span class="stat-number" data-target="20">0</span>
                        <span class="stat-label">Jenis Properti</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="50">0</span>
                        <span class="stat-label">Mitra Terpercaya</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="500">0</span>
                        <span class="stat-label">Total Pesanan</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: 2x2 Value propositions grid -->
            <div class="features-card-grid">
                <!-- Card 1 -->
                <div class="feature-about-card">
                    <div class="feature-icon-container">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <h3 class="feature-card-title">Data Informasi Lengkap</h3>
                    <p class="feature-card-desc">Fasilitas terperinci, spesifikasi kamar, harga sewa transparan, dilengkapi galeri foto beresolusi tinggi.</p>
                </div>

                <!-- Card 2 -->
                <div class="feature-about-card">
                    <div class="feature-icon-container">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </div>
                    <h3 class="feature-card-title">Tersebar di Seluruh Bali</h3>
                    <p class="feature-card-desc">Jaringan apartemen, villa, ruko, dan properti pilihan yang mencakup seluruh wilayah strategis di Bali.</p>
                </div>

                <!-- Card 3 -->
                <div class="feature-about-card">
                    <div class="feature-icon-container">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81 7A2 2 0 0 1 22 16.92z"></path></svg>
                    </div>
                    <h3 class="feature-card-title">Bantuan Standby 24/7</h3>
                    <p class="feature-card-desc">Tim layanan pelanggan profesional kami siap siaga mendampingi Anda di setiap tahap penyewaan.</p>
                </div>

                <!-- Card 4 -->
                <div class="feature-about-card">
                    <div class="feature-icon-container">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <h3 class="feature-card-title">Konsultasi Tanpa Biaya</h3>
                    <p class="feature-card-desc">Bebas berdiskusi dengan konsultan ahli kami untuk menyesuaikan tipe properti dengan budget Anda.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Curated Gallery Grid Section (Mockup 2) -->
    <section class="about-section" style="border-top: 1px solid var(--border-color); padding-top: 5rem;">
        <div class="gallery-header-row">
            <div>
                <span class="section-label">Galeri Pilihan</span>
                <h2 class="gallery-title">Jelajahi Galeri Kami</h2>
            </div>
            <p class="gallery-desc">
                Intip keindahan, kebersihan, dan kenyamanan dari portofolio unit apartemen serta villa terbaik yang dikelola langsung oleh mitra tepercaya kami di Bali.
            </p>
        </div>

        <div class="gallery-grid">
            @foreach($galleryProperties as $prop)
                <div class="gallery-item" onclick="window.location='{{ route('properties.show_public', $prop->id) }}'">
                    <img src="{{ $prop->image }}" alt="{{ $prop->title }}" class="gallery-img">
                    <div class="gallery-overlay">
                        <h4>{{ $prop->title }}</h4>
                        <p>{{ $prop->bedrooms }} Kamar Tidur | {{ $prop->location }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- CALL TO ACTION BANNER (Mockup 2) -->
    <div class="about-cta-container">
        <section class="about-cta-card">
            <span class="about-cta-label">Langkah Selanjutnya</span>
            <h2 class="about-cta-title">Siap Menemukan Properti Impian?</h2>
            <p class="about-cta-desc">
                Ribuan pilihan apartemen dan villa premium siap menyambut Anda. Cari sesuai lokasi yang Anda inginkan dan nikmati sewa tanpa ribet sekarang juga.
            </p>
            <button class="btn-cta-gold" onclick="window.location='/login'">
                <span>Daftar Sekarang</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </section>
    </div>

</div>

<!-- JavaScript for Interactive Carousel & Animated Stats -->
<script>
    // CAROUSEL LOGIC
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    let carouselInterval = setInterval(autoPlaySlide, 5000); // Auto-change every 5s

    function showSlide(index) {
        // Handle out-of-bounds index
        if (index >= slides.length) currentSlide = 0;
        else if (index < 0) currentSlide = slides.length - 1;
        else currentSlide = index;

        // Reset slide states
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Activate target slide and dot
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    function moveSlide(step) {
        clearInterval(carouselInterval); // Stop autoplay when clicked
        showSlide(currentSlide + step);
        carouselInterval = setInterval(autoPlaySlide, 5000); // Restart autoplay
    }

    function setSlide(index) {
        clearInterval(carouselInterval);
        showSlide(index);
        carouselInterval = setInterval(autoPlaySlide, 5000);
    }

    function autoPlaySlide() {
        showSlide(currentSlide + 1);
    }

    // ANIMATED STATS LOGIC
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-number');
        const speed = 100; // The higher the value, the slower the animation

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const initialText = counter.innerText;
            
            const updateCount = () => {
                const count = +counter.innerText.replace('+', '');
                
                // Get increment step
                const increment = Math.ceil(target / speed);
                
                if (count < target) {
                    counter.innerText = (count + increment) + '+';
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target + '+';
                }
            };
            
            updateCount();
        });
    }

    // Run counters when section is scrolled into view (Intersection Observer)
    const statsObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target); // Trigger only once
            }
        });
    }, { threshold: 0.5 });

    const statsSection = document.querySelector('.stats-row');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }
</script>
@endsection
