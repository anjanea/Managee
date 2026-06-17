@extends('layouts.app')

@section('title', 'Managee - Blog & Informasi Properti Terkini')

@section('content')
<!-- Custom Blog Styles -->
<style>
    :root {
        --emerald-primary: #1A3C34;
        --emerald-light: #2D6A4F;
        --emerald-glow: rgba(45, 106, 79, 0.15);
        --secondary-gold: #CA8A04;
        --secondary-gold-light: #EAB308;
        --text-dark: #1E293B;
        --text-slate: #475569;
        --text-light-slate: #64748B;
        --border-color: #E2E8F0;
        --card-bg: #FFFFFF;
        --bg-light-gray: #F8FAFC;
    }

    .blog-page-container {
        padding-top: 75px; /* Reduced to bring content higher */
        padding-bottom: 3rem;
        background-color: var(--bg-light-gray);
        font-family: 'Outfit', sans-serif;
    }

    /* Search Area (Opsi A) - Compacted */
    .search-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 1rem 1.5rem 0.5rem 1.5rem; /* Heavily reduced padding */
        background-color: var(--bg-light-gray);
    }

    .search-wrapper {
        position: relative;
        width: 100%;
        max-width: 600px; /* Tighter search bar width */
        margin-top: 0.5rem;
    }

    .search-input {
        width: 100%;
        padding: 0.95rem 1.5rem 0.95rem 3.25rem;
        font-size: 0.95rem;
        font-family: 'Outfit', sans-serif;
        color: var(--text-dark);
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-full);
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.03);
        outline: none;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: var(--emerald-light);
        box-shadow: 0 4px 15px var(--emerald-glow), 0 0 0 3px var(--emerald-glow);
    }

    .search-icon-wrapper {
        position: absolute;
        left: 1.15rem;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        pointer-events: none;
        color: var(--emerald-light);
        transition: transform 0.3s ease;
    }

    .search-input:focus + .search-icon-wrapper {
        transform: translateY(-50%) scale(1.1);
    }

    /* Category Chips Section - Aligned horizontally on a single line */
    .categories-section-wrapper {
        width: 100%;
        max-width: 1280px;
        margin: 0 auto 1rem auto;
        padding: 0 1.5rem;
        overflow: hidden;
    }

    .categories-section {
        display: flex;
        gap: 0.6rem;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none; /* Firefox */
        padding: 0.25rem 0.25rem 0.5rem 0.25rem;
        justify-content: flex-start;
    }

    .categories-section::-webkit-scrollbar {
        display: none; /* Safari & Chrome */
    }



    .category-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.5rem 1.1rem;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-slate);
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.01);
        flex-shrink: 0;
    }

    .category-chip:hover {
        border-color: var(--emerald-light);
        color: var(--emerald-light);
        background-color: rgba(45, 106, 79, 0.02);
        transform: translateY(-1px);
    }

    .category-chip.active {
        background-color: var(--emerald-primary);
        border-color: var(--emerald-primary);
        color: #FFFFFF;
        box-shadow: 0 3px 8px rgba(26, 60, 52, 0.15);
    }

    .category-chip.active svg {
        stroke: #FFFFFF;
    }

    /* Main Container - Extended max-width to reduce excessive side whitespace */
    .blog-content-wrapper {
        max-width: 1280px; /* Expanded from 1200px */
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* Featured Cards - Compacted height and paddings */
    .featured-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    @media (min-width: 992px) {
        .featured-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .featured-card {
        display: flex;
        background-color: var(--card-bg);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .featured-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.06);
        border-color: rgba(45, 106, 79, 0.15);
    }

    .featured-img-container {
        width: 38%; /* Slightly reduced width */
        min-height: 170px; /* Reduced from 220px to make card more compact */
        position: relative;
        overflow: hidden;
    }

    .featured-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .featured-card:hover .featured-img {
        transform: scale(1.03);
    }

    .featured-info {
        width: 62%;
        padding: 1.25rem; /* Reduced from 1.75rem */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .badge {
        display: inline-block;
        align-self: flex-start;
        padding: 0.3rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 600;
        border-radius: var(--radius-full);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }

    .badge-kuliner { background-color: #FAE8FF; color: #A855F7; }
    .badge-wisata { background-color: #E0F2FE; color: #0284C7; }
    .badge-hukum { background-color: #FEE2E2; color: #EF4444; }
    .badge-dekorasi { background-color: #FEF3C7; color: #D97706; }
    .badge-perawatan { background-color: #DCFCE7; color: #16A34A; }
    .badge-penyewa { background-color: #ECEFFF; color: #4F46E5; }

    .blog-title {
        font-size: 1.25rem; /* Reduced to look more balanced and fit fold */
        line-height: 1.3;
        font-weight: 700;
        color: var(--emerald-primary);
        margin-bottom: 0.5rem;
        transition: color 0.25s ease;
    }

    .blog-card:hover .blog-title,
    .featured-card:hover .blog-title {
        color: var(--emerald-light);
    }

    .blog-excerpt {
        font-size: 0.88rem;
        color: var(--text-slate);
        line-height: 1.45;
        margin-bottom: 0.75rem;
    }

    .blog-meta-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border-color);
        padding-top: 0.85rem;
    }

    .author-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--text-slate);
    }

    .author-avatar {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background-color: #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--emerald-primary);
        font-weight: 600;
        font-size: 0.7rem;
    }

    .meta-time-date {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.8rem;
        color: var(--text-light-slate);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .read-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--emerald-primary);
        transition: all 0.25s ease;
    }

    .featured-card:hover .read-more-btn {
        color: var(--emerald-light);
        transform: translateX(3px);
    }

    .stretched-link::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
    }

    /* Regular Grid Section (3 Columns) */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem; /* Tightened from 2rem */
        margin-bottom: 3rem;
    }

    .blog-card {
        background-color: var(--card-bg);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .blog-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.05);
        border-color: rgba(45, 106, 79, 0.15);
    }

    .card-img-container {
        height: 180px; /* Compacted height */
        position: relative;
        overflow: hidden;
        background-color: #E2E8F0;
    }

    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .blog-card:hover .card-img {
        transform: scale(1.03);
    }

    .card-info {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-title {
        font-size: 1.15rem;
        line-height: 1.4;
        font-weight: 700;
        color: var(--emerald-primary);
        margin-bottom: 0.5rem;
        transition: color 0.25s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-excerpt {
        font-size: 0.85rem;
        color: var(--text-slate);
        line-height: 1.45;
        margin-bottom: 1.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-meta-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border-color);
        padding-top: 0.85rem;
        margin-top: auto;
    }

    .card-chevron {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background-color: var(--bg-light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--emerald-primary);
        transition: all 0.25s ease;
    }

    .blog-card:hover .card-chevron {
        background-color: var(--emerald-primary);
        color: #FFFFFF;
        transform: translateX(2px);
    }

    /* Dynamic Article Detail View Styles */
    .detail-view-container {
        max-width: 800px;
        margin: 0 auto;
        background-color: var(--card-bg);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border-color);
        overflow: hidden;
        padding: 2.5rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: none;
        border: none;
        color: var(--text-light-slate);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        padding: 0;
        margin-bottom: 1.5rem;
        font-family: inherit;
        transition: color 0.2s ease;
    }

    .back-button:hover {
        color: var(--emerald-light);
    }

    .detail-header {
        margin-bottom: 1.5rem;
    }

    .detail-title {
        font-size: 2rem;
        color: var(--emerald-primary);
        font-weight: 700;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .detail-meta {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .detail-cover-container {
        width: 100%;
        height: 380px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
        background-color: #E2E8F0;
    }

    .detail-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-body {
        font-size: 1.05rem;
        color: var(--text-dark);
        line-height: 1.7;
    }

    .detail-body p {
        margin-bottom: 1.5rem;
    }

    /* Empty state */
    .empty-search-state {
        text-align: center;
        padding: 4rem 1.5rem;
        background-color: var(--card-bg);
        border-radius: 16px;
        border: 1px dashed var(--border-color);
        margin: 2rem 0;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .featured-card {
            flex-direction: column;
        }
        .featured-img-container {
            width: 100%;
            height: 200px;
        }
        .featured-info {
            width: 100%;
            padding: 1.25rem;
        }
        .blog-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    /* Write CTA Banner */
    .write-cta-banner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 0.85rem 1.25rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.01);
        gap: 1.5rem;
    }

    .write-cta-text h3 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--emerald-primary);
    }

    .write-cta-text p {
        margin: 0.25rem 0 0 0;
        font-size: 0.85rem;
        color: var(--text-slate);
        line-height: 1.4;
    }

    .btn-write-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: var(--secondary-gold);
        color: #FFFFFF;
        padding: 0.7rem 1.75rem;
        border-radius: 9999px;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(202, 138, 4, 0.15);
        transition: all 0.25s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-write-cta:hover {
        background-color: var(--secondary-gold-light);
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(202, 138, 4, 0.25);
    }

    @media (max-width: 768px) {
        .write-cta-banner {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
            padding: 1.25rem 1.5rem;
            gap: 1rem;
        }
        .btn-write-cta {
            justify-content: center;
            width: 100%;
        }
        .detail-view-container {
            padding: 1.5rem;
            border-radius: 12px;
        }
        .detail-title {
            font-size: 1.5rem;
        }
        .compact-blog-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-color: rgba(45, 106, 79, 0.15) !important;
        }
    }
</style>

<div class="blog-page-container">

    @if(session('success'))
        <div class="container" style="max-width: 1280px; margin-bottom: 1.5rem;">
            <div style="background-color: #DCFCE7; border: 1px solid #BBF7D0; color: #16A34A; padding: 1rem 1.5rem; border-radius: 12px; font-weight: 600; font-family: 'Outfit', sans-serif;">
                ✓ {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- BLOG LIST VIEW CONTAINER -->
    <div id="blog-list-view">
        <!-- Modern Split Header Section -->
        <section style="padding: 1rem 0 0.5rem 0; background-color: var(--bg-light-gray);">
            <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--emerald-primary); margin: 0; font-family: 'Outfit';">Artikel, Panduan & Regulasi Properti</h1>
                
                <!-- Search bar & Tulis Artikel button row -->
                <div style="display: flex; gap: 0.75rem; width: 100%; max-width: 480px; align-items: center;">
                    <div class="search-wrapper" style="flex-grow: 1; margin-top: 0; max-width: none;">
                        <input type="text" id="blog-search-input" class="search-input" placeholder="Cari artikel..." oninput="handleSearch()">
                        <div class="search-icon-wrapper">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('blog.create_public') }}" class="btn-write-cta" style="margin-top: 0; padding: 0.85rem 1.25rem; height: 48px; box-sizing: border-box; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                        <span style="margin-left: 0.35rem;">Tulis Artikel</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Category Filter Chips - Single row aligned -->
        <div class="categories-section-wrapper">
            <section class="categories-section">
                <button class="category-chip active" data-category="all" onclick="filterByCategory('all', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    <span>Semua Artikel</span>
                </button>
                <button class="category-chip" data-category="Panduan Pemilik" onclick="filterByCategory('Panduan Pemilik', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span>Panduan Pemilik</span>
                </button>
                <button class="category-chip" data-category="Panduan Penyewa" onclick="filterByCategory('Panduan Penyewa', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Panduan Penyewa</span>
                </button>
                <button class="category-chip" data-category="Hukum & Regulasi" onclick="filterByCategory('Hukum & Regulasi', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span>Hukum & Regulasi</span>
                </button>
                <button class="category-chip" data-category="Dekorasi & Renovasi" onclick="filterByCategory('Dekorasi & Renovasi', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Dekorasi & Renovasi</span>
                </button>
                <button class="category-chip" data-category="Kuliner" onclick="filterByCategory('Kuliner', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8V21M12 2v20M6 2v6M6 2a4 4 0 0 0 4 4M10 2a4 4 0 0 1 4 4"/></svg>
                    <span>Kuliner</span>
                </button>
                <button class="category-chip" data-category="Perawatan & Fasilitas" onclick="filterByCategory('Perawatan & Fasilitas', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                    <span>Kebersihan</span>
                </button>
                <button class="category-chip" data-category="Lainnya" onclick="filterByCategory('Lainnya', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    <span>Lainnya</span>
                </button>
            </section>
        </div>



        <!-- Main Articles Grid -->
        <div class="blog-content-wrapper">
                       <!-- Featured horizontal cards -->
            <div id="blog-featured-container" class="featured-grid" @if($posts->count() == 0) style="display: none;" @endif>
                @foreach($posts->take(2) as $post)
                    @php
                        $badgeClass = 'badge-penyewa';
                        if ($post->category == 'Kuliner') $badgeClass = 'badge-kuliner';
                        elseif ($post->category == 'Lainnya' || $post->category == 'Tempat Wisata') $badgeClass = 'badge-wisata';
                        elseif ($post->category == 'Hukum & Regulasi' || $post->category == 'Hukum') $badgeClass = 'badge-hukum';
                        elseif ($post->category == 'Dekorasi & Renovasi') $badgeClass = 'badge-dekorasi';
                        elseif ($post->category == 'Perawatan & Fasilitas') $badgeClass = 'badge-perawatan';
                        elseif ($post->category == 'Panduan Penyewa') $badgeClass = 'badge-penyewa';
                        elseif ($post->category == 'Panduan Pemilik' || $post->category == 'Tips Sewa' || $post->category == 'Strategi Bisnis') $badgeClass = 'badge-perawatan';
                    @endphp
                    <article class="featured-card" data-category="{{ $post->category }}" data-search-pool="{{ strtolower($post->title . ' ' . $post->category . ' ' . $post->author . ' ' . $post->summary) }}" onclick="openArticle('{{ $post->slug }}')">
                        @if(auth()->check() && $post->author === auth()->user()->name)
                            <div class="card-actions" style="position: absolute; top: 12px; right: 12px; z-index: 10; display: flex; gap: 0.5rem;">
                                <a href="{{ route('blog.edit_public', $post->slug) }}" onclick="event.stopPropagation();" class="action-btn edit-btn" title="Ubah Artikel" style="background: rgba(255, 255, 255, 0.95); padding: 0.45rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--emerald-primary); border: 1px solid var(--border-color); box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: all 0.2s;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <button type="button" onclick="event.stopPropagation(); confirmDeletePublic('{{ $post->slug }}', '{{ addslashes($post->title) }}')" class="action-btn delete-btn" title="Hapus Artikel" style="background: rgba(255, 255, 255, 0.95); padding: 0.45rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #EF4444; border: 1px solid var(--border-color); box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: all 0.2s;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        @endif
                        <div class="featured-img-container">
                            <img src="{{ $post->image ?: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600' }}" alt="{{ $post->title }}" class="featured-img" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600';">
                        </div>
                        <div class="featured-info">
                            <div>
                                <span class="badge {{ $badgeClass }}">{{ $post->category }}</span>
                                <h2 class="blog-title">
                                    <a href="javascript:void(0)" class="stretched-link">{{ $post->title }}</a>
                                </h2>
                                <p class="blog-excerpt">
                                    {{ $post->summary ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 120, '...') }}
                                </p>
                            </div>
                            
                            <div class="blog-meta-footer">
                                <div class="author-info">
                                    <div class="author-avatar">{{ strtoupper(substr($post->author ?: 'U', 0, 2)) }}</div>
                                    <span>{{ $post->author }}</span>
                                </div>
                                <div class="meta-time-date">
                                    <div class="meta-item">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        <span>{{ max(3, ceil(str_word_count(strip_tags($post->content)) / 200)) }} Menit</span>
                                    </div>
                                </div>
                                <span class="read-more-btn">
                                    <span>Baca Artikel</span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Vertical Grid -->
            <div id="blog-grid-container" class="blog-grid">
                @foreach($posts->slice(2) as $post)
                    @php
                        $badgeClass = 'badge-penyewa';
                        if ($post->category == 'Kuliner') $badgeClass = 'badge-kuliner';
                        elseif ($post->category == 'Lainnya' || $post->category == 'Tempat Wisata') $badgeClass = 'badge-wisata';
                        elseif ($post->category == 'Hukum & Regulasi' || $post->category == 'Hukum') $badgeClass = 'badge-hukum';
                        elseif ($post->category == 'Dekorasi & Renovasi') $badgeClass = 'badge-dekorasi';
                        elseif ($post->category == 'Perawatan & Fasilitas') $badgeClass = 'badge-perawatan';
                        elseif ($post->category == 'Panduan Penyewa') $badgeClass = 'badge-penyewa';
                        elseif ($post->category == 'Panduan Pemilik' || $post->category == 'Tips Sewa' || $post->category == 'Strategi Bisnis') $badgeClass = 'badge-perawatan';
                    @endphp
                    <article class="blog-card" data-category="{{ $post->category }}" data-search-pool="{{ strtolower($post->title . ' ' . $post->category . ' ' . $post->author . ' ' . $post->summary) }}" onclick="openArticle('{{ $post->slug }}')">
                        @if(auth()->check() && $post->author === auth()->user()->name)
                            <div class="card-actions" style="position: absolute; top: 12px; right: 12px; z-index: 10; display: flex; gap: 0.5rem;">
                                <a href="{{ route('blog.edit_public', $post->slug) }}" onclick="event.stopPropagation();" class="action-btn edit-btn" title="Ubah Artikel" style="background: rgba(255, 255, 255, 0.95); padding: 0.45rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--emerald-primary); border: 1px solid var(--border-color); box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: all 0.2s;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <button type="button" onclick="event.stopPropagation(); confirmDeletePublic('{{ $post->slug }}', '{{ addslashes($post->title) }}')" class="action-btn delete-btn" title="Hapus Artikel" style="background: rgba(255, 255, 255, 0.95); padding: 0.45rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #EF4444; border: 1px solid var(--border-color); box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: all 0.2s;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        @endif
                        <div class="card-img-container">
                            <img src="{{ $post->image ?: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600' }}" alt="{{ $post->title }}" class="card-img" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600';">
                        </div>
                        <div class="card-info">
                            <span class="badge {{ $badgeClass }}">{{ $post->category }}</span>
                            <h3 class="card-title">
                                <a href="javascript:void(0)" class="stretched-link">{{ $post->title }}</a>
                            </h3>
                            <p class="card-excerpt">
                                {{ $post->summary ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 120, '...') }}
                            </p>
                            <div class="card-meta-footer">
                                <div class="author-info">
                                    <div class="author-avatar">{{ strtoupper(substr($post->author ?: 'U', 0, 2)) }}</div>
                                    <span>{{ $post->author }}</span>
                                </div>
                                <div class="card-chevron">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Compact Search Results List (Shown when filter or search is active) -->
            <div id="blog-search-results-list" style="display: none; flex-direction: column; gap: 1rem; margin-bottom: 3rem;">
                @foreach($posts as $post)
                    @php
                        $badgeClass = 'badge-penyewa';
                        if ($post->category == 'Kuliner') $badgeClass = 'badge-kuliner';
                        elseif ($post->category == 'Lainnya' || $post->category == 'Tempat Wisata') $badgeClass = 'badge-wisata';
                        elseif ($post->category == 'Hukum & Regulasi' || $post->category == 'Hukum') $badgeClass = 'badge-hukum';
                        elseif ($post->category == 'Dekorasi & Renovasi') $badgeClass = 'badge-dekorasi';
                        elseif ($post->category == 'Perawatan & Fasilitas') $badgeClass = 'badge-perawatan';
                        elseif ($post->category == 'Panduan Penyewa') $badgeClass = 'badge-penyewa';
                        elseif ($post->category == 'Panduan Pemilik' || $post->category == 'Tips Sewa' || $post->category == 'Strategi Bisnis') $badgeClass = 'badge-perawatan';
                    @endphp
                    <article class="compact-blog-row" data-category="{{ $post->category }}" data-search-pool="{{ strtolower($post->title . ' ' . $post->category . ' ' . $post->author . ' ' . $post->summary) }}" onclick="openArticle('{{ $post->slug }}')" style="display: flex; gap: 1.25rem; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 1rem; cursor: pointer; transition: all 0.2s; align-items: center; position: relative;">
                        @if(auth()->check() && $post->author === auth()->user()->name)
                            <div class="card-actions" style="position: absolute; top: 12px; right: 12px; z-index: 10; display: flex; gap: 0.5rem;">
                                <a href="{{ route('blog.edit_public', $post->slug) }}" onclick="event.stopPropagation();" class="action-btn edit-btn" title="Ubah Artikel" style="background: rgba(255, 255, 255, 0.95); padding: 0.45rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--emerald-primary); border: 1px solid var(--border-color); box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: all 0.2s;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <button type="button" onclick="event.stopPropagation(); confirmDeletePublic('{{ $post->slug }}', '{{ addslashes($post->title) }}')" class="action-btn delete-btn" title="Hapus Artikel" style="background: rgba(255, 255, 255, 0.95); padding: 0.45rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #EF4444; border: 1px solid var(--border-color); box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: all 0.2s;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        @endif
                        <div style="width: 80px; height: 80px; border-radius: 8px; overflow: hidden; flex-shrink: 0; background-color: #E2E8F0;">
                            <img src="{{ $post->image ?: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600' }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600';">
                        </div>
                        <div style="flex-grow: 1; display: flex; flex-direction: column; gap: 0.25rem; padding-right: 50px;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                <span class="badge {{ $badgeClass }}" style="margin: 0; padding: 0.2rem 0.6rem; font-size: 0.65rem;">{{ $post->category }}</span>
                                <span style="font-size: 0.75rem; color: var(--text-light-slate);">Oleh <strong>{{ $post->author }}</strong> • {{ max(3, ceil(str_word_count(strip_tags($post->content)) / 200)) }} Menit</span>
                            </div>
                            <h4 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: var(--emerald-primary);">{{ $post->title }}</h4>
                            <p style="margin: 0; font-size: 0.82rem; color: var(--text-slate); display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $post->summary ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 120, '...') }}
                            </p>
                        </div>
                        <div class="card-chevron" style="flex-shrink: 0; margin-left: auto;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Empty search results -->
            <div id="blog-empty-state" class="empty-search-state" style="{{ $posts->count() == 0 ? 'display: block;' : 'display: none;' }}">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-light-slate)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                <h3 style="color: var(--emerald-primary); margin-bottom: 0.5rem;">Artikel Tidak Ditemukan</h3>
                <p style="color: var(--text-slate); font-size: 0.95rem;">Tidak ada artikel yang cocok dengan kata kunci atau kategori yang Anda pilih.</p>
                <button onclick="resetFilters()" style="margin-top: 1.25rem; background-color: var(--emerald-primary); color: #FFFFFF; border: none; padding: 0.6rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; font-family: inherit; transition: var(--transition);" onmouseover="this.style.backgroundColor='var(--emerald-light)'" onmouseout="this.style.backgroundColor='var(--emerald-primary)'">Reset Pencarian</button>
            </div>

        </div>
    </div>


    <!-- BLOG DYNAMIC ARTICLE DETAIL VIEW (Hidden by default) -->
    <div id="blog-detail-view" style="display: none; padding-top: 1.5rem;">
        <div class="container" style="max-width: 900px; padding: 0 1.5rem;">
            
            <button class="back-button" onclick="closeArticle()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Kembali ke Daftar Artikel</span>
            </button>

            <div class="detail-view-container">
                <div class="detail-header">
                    <span id="detail-badge" class="badge">Kategori</span>
                    <h1 id="detail-title" class="detail-title">Judul Artikel Lengkap</h1>
                    
                    <div class="detail-meta">
                        <div class="author-info">
                            <div id="detail-avatar" class="author-avatar">A</div>
                            <span id="detail-author">Nama Penulis</span>
                        </div>
                        <div class="meta-time-date">
                            <div class="meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span id="detail-readtime">5 Menit</span>
                            </div>
                            <div class="meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span id="detail-date">25 Mei 2026</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-cover-container">
                    <img id="detail-cover-img" src="" alt="Cover Properti" class="detail-cover" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600';">
                </div>

                <div id="detail-body-text" class="detail-body">
                    <!-- Dynamic Paragraphs Go Here -->
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Centered Delete Confirmation Modal -->
<div id="delete-confirm-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center; transition: all 0.3s ease;">
    <div style="background: #FFFFFF; border-radius: 16px; padding: 2rem; max-width: 450px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); text-align: center; border: 1px solid var(--border-color); animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <!-- Warning Icon -->
        <div style="background: #FEE2E2; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem auto; color: #EF4444;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>

        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--emerald-primary); margin-bottom: 0.5rem; font-family: 'Outfit';">Konfirmasi Hapus Artikel</h3>
        <p style="font-size: 0.9rem; color: var(--text-slate); line-height: 1.5; margin-bottom: 1.75rem;">
            Apakah Anda yakin ingin menghapus artikel <strong id="delete-post-title" style="color: var(--text-dark);"></strong>? Tindakan ini tidak dapat dibatalkan.
        </p>

        <!-- Hidden Form -->
        <form id="delete-post-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 0.75rem; justify-content: center;">
                <button type="button" onclick="closeDeleteModal()" class="btn-mock-cancel" style="padding: 0.65rem 1.5rem; margin: 0; width: 100%; border-radius: 8px; font-size: 0.9rem;">
                    Batal
                </button>
                <button type="submit" style="background-color: #EF4444; color: #FFFFFF; border: none; font-family: inherit; font-size: 0.9rem; font-weight: 700; padding: 0.65rem 1.5rem; border-radius: 8px; cursor: pointer; width: 100%; transition: all 0.2s ease; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    .action-btn:hover {
        transform: scale(1.1);
        background-color: #FFFFFF !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }
</style>

<!-- JavaScript Logic for Search, Category Filtering, and Dynamic Article View -->
<script>
    let activeCategory = 'all';
    let searchQuery = '';

    // Article Content Database
    const articlesDb = {
        @foreach($posts as $post)
        '{{ $post->slug }}': {
            title: {!! json_encode($post->title) !!},
            category: {!! json_encode($post->category) !!},
            badgeClass: getBadgeClass({!! json_encode($post->category) !!}),
            author: {!! json_encode($post->author) !!},
            authorInitials: {!! json_encode(strtoupper(substr($post->author ?: 'U', 0, 2))) !!},
            readTime: '{{ max(3, ceil(str_word_count(strip_tags($post->content)) / 200)) }} Menit',
            date: '{{ $post->created_at ? $post->created_at->translatedFormat("d M Y") : "Baru Saja" }}',
            img: {!! json_encode($post->image ?: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600') !!},
            paragraphs: {!! json_encode(explode("\n", str_replace("\r", "", $post->content))) !!}
        },
        @endforeach
    };

    // Filter Chips Action
    function filterByCategory(category, element) {
        document.querySelectorAll('.category-chip').forEach(chip => {
            chip.classList.remove('active');
        });
        element.classList.add('active');
        
        activeCategory = category;
        applyFilters();
    }

    // Real-time Search Input Action
    function handleSearch() {
        const searchInput = document.getElementById('blog-search-input');
        searchQuery = searchInput.value.toLowerCase().trim();
        applyFilters();
    }

    // Filter Application logic
    function applyFilters() {
        const featuredContainer = document.getElementById('blog-featured-container');
        const gridContainer = document.getElementById('blog-grid-container');
        const listContainer = document.getElementById('blog-search-results-list');
        const emptyState = document.getElementById('blog-empty-state');
        const compactRows = document.querySelectorAll('.compact-blog-row');

        const isFiltering = (activeCategory !== 'all' || searchQuery !== '');

        if (isFiltering) {
            // Hide normal grid layouts
            if (featuredContainer) featuredContainer.style.display = 'none';
            if (gridContainer) gridContainer.style.display = 'none';
            
            // Show list view layout
            listContainer.style.display = 'flex';

            let visibleMatches = 0;
            compactRows.forEach(row => {
                const category = row.getAttribute('data-category');
                const searchPool = row.getAttribute('data-search-pool');

                const matchesCategory = (activeCategory === 'all' || category === activeCategory);
                const matchesSearch = (searchQuery === '' || searchPool.includes(searchQuery));

                if (matchesCategory && matchesSearch) {
                    row.style.display = 'flex';
                    visibleMatches++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show empty state if nothing found
            if (visibleMatches === 0) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        } else {
            // Restore normal layouts when not filtering
            if (featuredContainer) featuredContainer.style.display = 'grid';
            if (gridContainer) gridContainer.style.display = 'grid';
            
            listContainer.style.display = 'none';
            emptyState.style.display = 'none';

            // Also ensure all compact rows are reset
            compactRows.forEach(row => {
                row.style.display = 'none';
            });
        }
    }

    function resetFilters() {
        const searchInput = document.getElementById('blog-search-input');
        searchInput.value = '';
        searchQuery = '';
        const allChip = document.querySelector('.category-chip[data-category="all"]');
        filterByCategory('all', allChip);
    }

    // DYNAMIC DETAILED ARTICLE VIEWER LOGIC
    function openArticle(id) {
        const article = articlesDb[id];
        if (!article) return;

        // Populate detail view DOM
        const badge = document.getElementById('detail-badge');
        badge.textContent = article.category;
        badge.className = 'badge ' + getBadgeClass(article.category);
        
        document.getElementById('detail-title').textContent = article.title;
        document.getElementById('detail-author').textContent = article.author;
        document.getElementById('detail-avatar').textContent = article.authorInitials;
        document.getElementById('detail-readtime').textContent = article.readTime;
        document.getElementById('detail-date').textContent = article.date;
        document.getElementById('detail-cover-img').src = article.img;
        document.getElementById('detail-cover-img').alt = article.title;

        // Construct paragraphs
        const bodyContainer = document.getElementById('detail-body-text');
        bodyContainer.innerHTML = '';
        article.paragraphs.forEach(para => {
            const pElement = document.createElement('p');
            pElement.textContent = para;
            bodyContainer.appendChild(pElement);
        });

        // Hide list view and show detail view
        document.getElementById('blog-list-view').style.display = 'none';
        document.getElementById('blog-detail-view').style.display = 'block';

        // Smooth scroll to top of viewport
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function closeArticle() {
        // Hide detail view and restore list view
        document.getElementById('blog-detail-view').style.display = 'none';
        document.getElementById('blog-list-view').style.display = 'block';
        
        // Scroll back to where the search bar is
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function getBadgeClass(category) {
        switch(category) {
            case 'Kuliner': return 'badge-kuliner';
            case 'Lainnya': return 'badge-wisata';
            case 'Hukum & Regulasi': return 'badge-hukum';
            case 'Dekorasi & Renovasi': return 'badge-dekorasi';
            case 'Perawatan & Fasilitas': return 'badge-perawatan';
            case 'Panduan Penyewa': return 'badge-penyewa';
            default: return 'badge-tips';
        }
    }

    function confirmDeletePublic(slug, title) {
        const modal = document.getElementById('delete-confirm-modal');
        const titleSpan = document.getElementById('delete-post-title');
        const form = document.getElementById('delete-post-form');
        
        titleSpan.textContent = `"${title}"`;
        form.action = `/blog/${slug}/hapus`;
        
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-confirm-modal');
        modal.style.display = 'none';
    }
</script>
@endsection
