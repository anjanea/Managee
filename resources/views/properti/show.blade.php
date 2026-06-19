@extends('layouts.app')

@section('title', 'Managee - ' . $property->title)

@section('content')
@php
    $totalReviewsCount = $dbReviews->count();
    $stars5Count = $dbReviews->where('stars', 5)->count();
    $stars4Count = $dbReviews->where('stars', 4)->count();
    $stars3Count = $dbReviews->where('stars', 3)->count();
    $stars2Count = $dbReviews->where('stars', 2)->count();
    $stars1Count = $dbReviews->where('stars', 1)->count();
    
    $stars5Percent = $totalReviewsCount > 0 ? round(($stars5Count / $totalReviewsCount) * 100) : 0;
    $stars4Percent = $totalReviewsCount > 0 ? round(($stars4Count / $totalReviewsCount) * 100) : 0;
    $stars3Percent = $totalReviewsCount > 0 ? round(($stars3Count / $totalReviewsCount) * 100) : 0;
    $stars2Percent = $totalReviewsCount > 0 ? round(($stars2Count / $totalReviewsCount) * 100) : 0;
    $stars1Percent = $totalReviewsCount > 0 ? round(($stars1Count / $totalReviewsCount) * 100) : 0;
    
    // Average star rating
    $avgRating = $totalReviewsCount > 0 ? number_format($dbReviews->avg('stars'), 1) : number_format($property->stars, 1);
@endphp
<!-- Custom Property Detail Styles -->
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

    .detail-page-container {
        padding-top: 100px; /* Offset for fixed navbar */
        padding-bottom: 5rem;
        background-color: #FFFFFF;
        font-family: 'Outfit', sans-serif;
    }

    /* Breadcrumbs */
    .breadcrumb-wrapper {
        margin-bottom: 1.25rem;
        font-size: 0.85rem;
        color: var(--text-light-slate);
        font-weight: 500;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .breadcrumb-wrapper a {
        color: var(--text-light-slate);
        text-decoration: none;
        transition: var(--transition);
    }

    .breadcrumb-wrapper a:hover {
        color: var(--emerald-light);
    }

    .breadcrumb-separator {
        margin: 0 0.5rem;
        opacity: 0.6;
        display: inline-flex;
        align-items: center;
    }

    /* Title & Meta Header */
    .property-detail-header {
        margin-bottom: 2rem;
    }

    .detail-property-title {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--emerald-primary);
        margin: 0 0 0.75rem 0;
        line-height: 1.2;
    }

    .detail-property-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        font-size: 0.9rem;
        color: var(--text-slate);
    }

    .meta-rating {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .meta-rating svg {
        width: 16px;
        height: 16px;
        fill: var(--secondary-gold);
        stroke: var(--secondary-gold);
    }

    .meta-location {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        color: var(--text-slate);
    }

    .meta-location svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
    }

    /* Gallery Grid (5 images mockup style) */
    .detail-gallery-grid {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 0.75rem;
        height: 440px;
        margin-bottom: 3rem;
        border-radius: 16px;
        overflow: hidden;
    }

    .gallery-main-pane {
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .gallery-side-pane {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 0.75rem;
        height: 100%;
    }

    .gallery-img-box {
        width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
        background-color: #F1F5F9;
    }

    .gallery-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .gallery-img-box:hover .gallery-photo {
        transform: scale(1.04);
    }

    /* Two Column Layout */
    .detail-content-layout {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 3rem;
        align-items: flex-start;
    }

    .content-left {
        display: flex;
        flex-direction: column;
        gap: 2.5rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin: 0 0 1rem 0;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 0.5rem;
    }

    .description-text {
        font-size: 1rem;
        color: var(--text-slate);
        line-height: 1.65;
    }

    .description-text p {
        margin-bottom: 1.25rem;
    }

    /* Facilities Grid */
    .facilities-container {
        background-color: var(--bg-light-gray);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
    }

    .facilities-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem 2rem;
    }

    .facility-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .facility-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--emerald-light);
        flex-shrink: 0;
    }

    /* Right Sticky Card (Booking Card) */
    .content-right {
        position: sticky;
        top: 110px;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Fee Included Banner */
    .all-inclusive-banner {
        background-color: #FFF5F5;
        border: 1px solid #FEB2B2;
        color: #E53E3E;
        border-radius: 12px;
        padding: 0.85rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.9rem;
        font-weight: 700;
        box-shadow: 0 2px 10px rgba(229, 62, 62, 0.04);
    }

    .all-inclusive-banner svg {
        flex-shrink: 0;
    }

    /* Booking Form Card */
    .booking-card {
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
    }

    .booking-price-header {
        display: flex;
        align-items: baseline;
        gap: 0.25rem;
        margin-bottom: 1.5rem;
    }

    .booking-price {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--emerald-primary);
    }

    .booking-price-period {
        font-size: 0.9rem;
        color: var(--text-light-slate);
        font-weight: 500;
    }

    .booking-form-group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .booking-field {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .booking-field label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .booking-input {
        width: 100%;
        padding: 0.75rem 1rem;
        font-family: inherit;
        font-size: 0.9rem;
        color: var(--text-dark);
        background-color: var(--bg-light-gray);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        outline: none;
        transition: all 0.25s ease;
    }

    .booking-input:focus {
        border-color: var(--emerald-light);
        background-color: #FFFFFF;
        box-shadow: 0 0 0 3px var(--emerald-glow);
    }

    /* Pricing Summary */
    .pricing-summary {
        border-top: 1px solid var(--border-color);
        padding-top: 1.25rem;
        margin-top: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .pricing-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--text-slate);
    }

    .pricing-row.total-row {
        border-top: 1px solid var(--border-color);
        padding-top: 0.75rem;
        margin-top: 0.25rem;
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--emerald-primary);
    }

    .btn-submit-booking {
        width: 100%;
        background-color: var(--secondary-gold);
        color: #FFFFFF;
        border: none;
        padding: 1rem;
        border-radius: 8px;
        font-family: inherit;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(202, 138, 4, 0.2);
        margin-top: 1.5rem;
    }

    .btn-submit-booking:hover {
        background-color: var(--secondary-gold-light);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(202, 138, 4, 0.3);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .detail-gallery-grid {
            height: 320px;
        }
        .detail-content-layout {
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }
        .content-right {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .detail-page-container {
            padding-top: 80px;
        }
        .detail-property-title {
            font-size: 1.75rem;
        }
        .detail-gallery-grid {
            grid-template-columns: 1fr;
            height: 240px;
        }
        .gallery-side-pane {
            display: none;
        }
        .facilities-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Reviews Section */
    .reviews-section {
        margin-top: 4rem;
        border-top: 1.5px solid var(--border-color);
        padding-top: 3rem;
    }

    .reviews-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }

    .reviews-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin: 0;
    }

    .reviews-header .rating-avg {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .reviews-header .rating-avg svg {
        width: 18px;
        height: 18px;
        fill: var(--secondary-gold);
        stroke: var(--secondary-gold);
    }

    .review-list {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    .review-item {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .review-user-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .review-user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .review-user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: var(--emerald-primary);
        color: #FFFFFF;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .review-user-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .review-user-date {
        font-size: 0.85rem;
        color: var(--text-light-slate);
        margin: 0.15rem 0 0 0;
    }

    .review-stars {
        display: flex;
        gap: 0.15rem;
        color: var(--secondary-gold);
    }

    .review-stars svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    .review-text {
        font-size: 0.95rem;
        color: var(--text-slate);
        line-height: 1.6;
        margin: 0;
    }

    .btn-show-more-reviews {
        display: inline-flex;
        align-items: center;
        background-color: var(--bg-light-gray);
        color: var(--text-dark);
        border: 1px solid var(--border-color);
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-show-more-reviews:hover {
        background-color: var(--border-color);
    }

    /* Related Properties Section */
    .related-properties-section {
        margin-top: 4rem;
        border-top: 1.5px solid var(--border-color);
        padding-top: 3rem;
    }

    .related-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin-bottom: 2rem;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
    }

    .related-card {
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
    }

    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .related-card-img {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }

    .related-card-info {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .related-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin: 0 0 0.5rem 0;
    }

    .related-card-stars {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .related-card-stars svg {
        width: 14px;
        height: 14px;
        fill: var(--secondary-gold);
        stroke: var(--secondary-gold);
    }

    .related-card-address {
        font-size: 0.85rem;
        color: var(--text-slate);
        margin: 0 0 1rem 0;
    }

    .related-card-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--emerald-primary);
        margin-top: auto;
    }

    /* Reviews Modal Overlay */
    .reviews-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        animation: fadeIn 0.25s ease-out;
    }

    .reviews-modal-card {
        background-color: #FFFFFF;
        border-radius: 20px;
        width: 100%;
        max-width: 860px;
        height: 80vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 1px solid var(--border-color);
    }

    .reviews-modal-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #FFFFFF;
    }

    .reviews-modal-header .modal-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--emerald-primary);
        margin: 0;
    }

    .reviews-modal-header .modal-subtitle {
        font-size: 0.85rem;
        color: var(--text-light-slate);
        margin: 0.2rem 0 0 0;
    }

    .reviews-modal-close {
        background: none;
        border: none;
        color: var(--text-slate);
        cursor: pointer;
        padding: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
        border-radius: 50%;
    }

    .reviews-modal-close:hover {
        color: #EF4444;
        background-color: var(--bg-light-gray);
    }

    .reviews-modal-body {
        padding: 2rem;
        display: grid;
        grid-template-columns: 1fr 1.6fr;
        gap: 2.5rem;
        overflow: hidden;
        flex-grow: 1;
    }

    /* Rating Stats Pane */
    .rating-stats-pane {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .rating-huge-score {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        background-color: var(--bg-light-gray);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .rating-huge-score .score-num {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--emerald-primary);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .rating-huge-score .score-stars {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-slate);
    }

    .rating-huge-score .score-stars svg {
        width: 20px;
        height: 20px;
        fill: var(--secondary-gold);
        stroke: var(--secondary-gold);
    }

    .rating-bars-container {
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
    }

    .rating-bar-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-slate);
    }

    .rating-bar-row .bar-label {
        width: 60px;
        text-align: right;
        flex-shrink: 0;
    }

    .rating-bar-row .bar-bg {
        flex-grow: 1;
        height: 8px;
        background-color: #E2E8F0;
        border-radius: 9999px;
        overflow: hidden;
    }

    .rating-bar-row .bar-fill {
        height: 100%;
        background-color: var(--secondary-gold);
        border-radius: 9999px;
    }

    .rating-bar-row .bar-percent {
        width: 35px;
        text-align: left;
        color: var(--text-dark);
        flex-shrink: 0;
    }

    .reviews-list-scrollable {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    /* Custom scrollbar for modal body & reviews list */
    .reviews-modal-body::-webkit-scrollbar,
    .reviews-list-scrollable::-webkit-scrollbar {
        width: 6px;
    }
    .reviews-modal-body::-webkit-scrollbar-track,
    .reviews-list-scrollable::-webkit-scrollbar-track {
        background: transparent;
    }
    .reviews-modal-body::-webkit-scrollbar-thumb,
    .reviews-list-scrollable::-webkit-scrollbar-thumb {
        background-color: var(--border-color);
        border-radius: 10px;
    }

    /* Modal Search and Filter CSS */
    .reviews-filter-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        flex-shrink: 0;
    }
    .reviews-search-box {
        position: relative;
        width: 100%;
    }
    .reviews-search-input {
        width: 100%;
        padding: 0.65rem 1rem 0.65rem 2.5rem;
        font-family: inherit;
        font-size: 0.9rem;
        color: var(--text-dark);
        background-color: var(--bg-light-gray);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        outline: none;
        transition: all 0.2s ease;
    }
    .reviews-search-input:focus {
        border-color: var(--emerald-light);
        background-color: #FFFFFF;
        box-shadow: 0 0 0 3px var(--emerald-glow);
    }
    .reviews-search-icon {
        position: absolute;
        left: 0.85rem;
        top: 52%;
        transform: translateY(-50%);
        color: var(--text-light-slate);
        pointer-events: none;
        display: flex;
        align-items: center;
    }
    .reviews-filter-pills {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .filter-pill {
        padding: 0.4rem 0.85rem;
        font-size: 0.8rem;
        font-weight: 700;
        border-radius: 9999px;
        background-color: var(--bg-light-gray);
        border: 1px solid var(--border-color);
        color: var(--text-slate);
        cursor: pointer;
        transition: all 0.2s ease;
        outline: none;
    }
    .filter-pill:hover {
        background-color: var(--border-color);
        color: var(--text-dark);
    }
    .filter-pill.active {
        background-color: var(--emerald-primary);
        border-color: var(--emerald-primary);
        color: #FFFFFF;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @media (max-width: 768px) {
        .reviews-modal-body {
            grid-template-columns: 1fr;
            gap: 2rem;
            overflow-y: auto;
        }
    }
</style>

<div class="detail-page-container">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <div class="breadcrumb-wrapper">
            <a href="/">Beranda</a>
            <span class="breadcrumb-separator">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </span>
            <a href="/properti">Properti</a>
            <span class="breadcrumb-separator">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </span>
            <span style="color: var(--emerald-primary); font-weight: 600;">{{ $property->title }}</span>
        </div>

        @if(session('warning'))
            <div style="background-color: #FFF3CD; border: 1px solid #FFEBA5; color: #856404; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; font-family: 'Outfit', sans-serif;">
                <span>⚠️</span>
                <span>{{ session('warning') }}</span>
            </div>
        @endif

        <!-- Title and Stars Header -->
        <header class="property-detail-header">
            <h1 class="detail-property-title">{{ $property->title }}</h1>
            <div class="detail-property-meta">
                <span class="meta-rating">
                    @if($totalReviewsCount > 0)
                        <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <span>{{ $avgRating }}</span>
                        <span style="color: var(--text-light-slate); font-weight: normal; font-size: 0.85rem;">({{ $totalReviewsCount }} ulasan)</span>
                    @else
                        <span style="color: var(--text-light-slate); font-weight: 500; font-style: italic;">Belum ada ulasan</span>
                    @endif
                </span>
                <span class="meta-location">
                    <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <span>{{ $property->address }}</span>
                </span>
            </div>
        </header>

        @php
            $galleryImages = is_array($property->images) ? $property->images : [];
            if (empty($galleryImages) && $property->image) {
                $galleryImages[] = $property->image;
            }
            // Fallbacks if images count is less than 5
            $fallbacks = [
                $property->image ?: 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&q=80&w=400',
                'https://images.unsplash.com/photo-1507089947368-19c1da9775ae?auto=format&fit=crop&q=80&w=400',
                'https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&q=80&w=400',
                'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&q=80&w=400'
            ];
            for ($i = 0; $i < 5; $i++) {
                if (!isset($galleryImages[$i])) {
                    $galleryImages[$i] = $fallbacks[$i];
                }
            }
        @endphp

        <!-- Gallery Grid (1 Main + 4 Thumbnails) -->
        <section class="detail-gallery-grid">
            <div class="gallery-main-pane">
                <div class="gallery-img-box" style="cursor: pointer;" onclick="openLightbox({{ json_encode($galleryImages) }}, 0)">
                    <img src="{{ $galleryImages[0] }}" alt="{{ $property->title }}" class="gallery-photo">
                </div>
            </div>
            
            <div class="gallery-side-pane">
                <!-- Thumbnail 1 -->
                <div class="gallery-img-box" style="cursor: pointer;" onclick="openLightbox({{ json_encode($galleryImages) }}, 1)">
                    <img src="{{ $galleryImages[1] }}" alt="Detail Properti 1" class="gallery-photo">
                </div>
                <!-- Thumbnail 2 -->
                <div class="gallery-img-box" style="cursor: pointer;" onclick="openLightbox({{ json_encode($galleryImages) }}, 2)">
                    <img src="{{ $galleryImages[2] }}" alt="Detail Properti 2" class="gallery-photo">
                </div>
                <!-- Thumbnail 3 -->
                <div class="gallery-img-box" style="cursor: pointer;" onclick="openLightbox({{ json_encode($galleryImages) }}, 3)">
                    <img src="{{ $galleryImages[3] }}" alt="Detail Properti 3" class="gallery-photo">
                </div>
                <!-- Thumbnail 4 -->
                <div class="gallery-img-box" style="cursor: pointer;" onclick="openLightbox({{ json_encode($galleryImages) }}, 4)">
                    <img src="{{ $galleryImages[4] }}" alt="Detail Properti 4" class="gallery-photo">
                </div>
            </div>
        </section>

        <!-- Two Column Layout Content -->
        <div class="detail-content-layout">
            
            <!-- Left Column: Description & Facilities -->
            <div class="content-left">
                <!-- Description -->
                <article>
                    <h2 class="section-title">Deskripsi</h2>
                    <div class="description-text">
                        @if($property->description)
                            <p>{{ $property->description }}</p>
                        @else
                            <p>
                                Properti mewah dengan desain minimalis modern di lokasi yang sangat strategis. Dikelilingi oleh lingkungan yang tenang, properti ini menawarkan kenyamanan optimal yang cocok untuk beristirahat dari rutinitas harian Anda di Bali.
                            </p>
                            <p>
                                Dilengkapi dengan interior berperabotan lengkap (fully furnished) dengan standar kualitas tinggi, dapur yang bersih dan siap pakai, ruang keluarga yang lapang, serta pendingin udara di setiap ruangan. Gedung ini juga memiliki sistem keamanan 24 jam dengan pemantauan kamera CCTV di setiap sudut demi menjamin keamanan masa tinggal Anda.
                            </p>
                            <p>
                                Sangat ideal untuk ekspatriat, wisatawan domestik maupun mancanegara, serta pasangan muda yang menginginkan tempat tinggal berkelas dengan akses mudah menuju pantai, kafe, restoran terpopuler, dan fasilitas umum penting lainnya.
                            </p>
                        @endif
                    </div>
                </article>

                <!-- Spesifikasi Detail -->
                <section class="specs-container" style="background-color: var(--bg-light-gray); border: 1px solid var(--border-color); border-radius: 16px; padding: 2rem; margin-top: 1rem; font-family: 'Outfit', sans-serif;">
                    <h2 class="section-title" style="border-bottom: none; padding-bottom: 0; margin-bottom: 1.5rem;">Spesifikasi Detail</h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem 2.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Kamar Tidur</span>
                            <span style="font-size: 1rem; color: var(--text-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M2 4v16"></path><path d="M2 8h18a2 2 0 0 1 2 2v10"></path><path d="M2 17h20"></path><path d="M6 8v9"></path></svg>
                                {{ $property->bedrooms ?: '-' }} Kamar
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Kamar Mandi</span>
                            <span style="font-size: 1rem; color: var(--text-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M9 6V2h6v4"></path><path d="M12 2v4"></path><path d="M3 12h18v5a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4v-5z"></path><path d="M7 12V9a5 5 0 0 1 10 0v3"></path></svg>
                                {{ $property->bathrooms ?: '-' }} Ruang
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Luas Properti</span>
                            <span style="font-size: 1rem; color: var(--text-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18M15 3v18M3 9h18M3 15h18"/></svg>
                                {{ $property->area }} m²
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Jumlah Lantai</span>
                            <span style="font-size: 1rem; color: var(--text-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M3 9h18M3 15h18M3 21h18M3 3h18"/></svg>
                                {{ $property->floors ?: '-' }} Lantai
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Kapasitas Garasi</span>
                            <span style="font-size: 1rem; color: var(--text-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 17v-4h6v4M9 9h6"/></svg>
                                {{ $property->garage ?: '-' }}
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Tahun Pembangunan</span>
                            <span style="font-size: 1rem; color: var(--text-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $property->year_built ?: '-' }}
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Status Sertifikat</span>
                            <span style="font-size: 1rem; color: var(--text-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                {{ $property->certificate ?: '-' }}
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Daya Listrik</span>
                            <span style="font-size: 1rem; color: var(--text-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                {{ $property->electricity ? $property->electricity . ' Watt' : '-' }}
                            </span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Penyediaan Air</span>
                            <span style="font-size: 1rem; color: var(--text-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M12 22a7 7 0 0 0 7-7c0-4.3-7-11-7-11S5 10.7 5 15a7 7 0 0 0 7 7z"/></svg>
                                {{ $property->water_source ?: '-' }}
                            </span>
                        </div>
                    </div>
                </section>

                <!-- Facilities -->
                <section class="facilities-container">
                    <h2 class="section-title" style="border-bottom: none; padding-bottom: 0;">Fasilitas</h2>
                    
                    @php
                        $facilityList = is_array($property->facilities) ? $property->facilities : [];
                        // Fallback list of default facilities if the property has none (e.g. seeded properties)
                        if (empty($facilityList)) {
                            $facilityList = ['Pemandangan Sawah', 'Ruang kerja', 'Wifi', 'AC', 'HDTV 45 inci dengan Netflix', 'Lift', 'Kolam Renang', 'Dapur'];
                        }

                        // Map facility names to clean, correct SVGs
                        $facilityIcons = [
                            'Pemandangan Sawah' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>',
                            'Ruang kerja' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>',
                            'Wifi' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><circle cx="12" cy="20" r="1"></circle></svg>',
                            'Wi-Fi' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><circle cx="12" cy="20" r="1"></circle></svg>',
                            'AC' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="22"></line><line x1="2" y1="12" x2="22" y2="12"></line><path d="M20 16l-4-4 4-4M4 8l4 4-4 4M16 4l-4 4-4-4M8 20l4-4 4 4"></path></svg>',
                            'HDTV 45 inci dengan Netflix' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>',
                            'Lift' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><polyline points="9 10 12 7 15 10"></polyline><polyline points="9 14 12 17 15 14"></polyline></svg>',
                            'Kolam Renang' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 6c.6.5 1.2 1 2.5 1C5.8 7 7 5.8 7 5s1.2-2 2.5-2c1.3 0 2.5 1.2 2.5 2s1.2 2 2.5 2c1.3 0 2.5-1.2 2.5-2s1.2-2 2.5-2c1.3 0 2.5 1.2 2.5 2M2 12c.6.5 1.2 1 2.5 1 1.3 0 2.5-1.2 2.5-2s1.2-2 2.5-2c1.3 0 2.5 1.2 2.5 2s1.2 2 2.5 2c1.3 0 2.5-1.2 2.5-2s1.2-2 2.5-2c1.3 0 2.5 1.2 2.5 2M2 18c.6.5 1.2 1 2.5 1 1.3 0 2.5-1.2 2.5-2s1.2-2 2.5-2c1.3 0 2.5 1.2 2.5 2s1.2 2 2.5 2c1.3 0 2.5-1.2 2.5-2s1.2-2 2.5-2c1.3 0 2.5 1.2 2.5 2"></path></svg>',
                            'Dapur' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2M7 2v4M11 2v4M15 14v6h3v-6a3 3 0 0 0-6 0v6h3v-6M12 18h9"/></svg>',
                            'Security 24 Jam' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
                            'Furniture' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 9a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2m-2 10V9a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v10M2 14h20"></path></svg>',
                            'TV Kabel' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="15" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>',
                            'Gym' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h2a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-2M6 8H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2M6 5v14M18 5v14M6 12h12"></path></svg>',
                            'Garasi' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><path d="M9 17v-4h6v4M9 9h6"></path></svg>',
                            'CCTV' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 7l-7 5 7 5V7z"></path><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>',
                            'Balkon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 14h18M3 18h18M3 22h18M3 10V2h18v8"></path></svg>',
                            'Parkir Motor' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="18" r="3"></circle><circle cx="19" cy="18" r="3"></circle><path d="M19 18v-4l-2-5H9L6 14v4M12 5v9"></path></svg>',
                            'Taman' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 13-5 3h10l-5-3zm0-9-8 5h16l-8-5zM12 16v5"/></svg>',
                            'Laundry' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><circle cx="12" cy="13" r="5"></circle><line x1="8" y1="6" x2="8.01" y2="6"></line><line x1="12" y1="6" x2="12.01" y2="6"></line><line x1="16" y1="6" x2="16.01" y2="6"></line></svg>',
                            'Playground' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"></path></svg>',
                        ];
                        
                        $defaultIcon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>';
                    @endphp

                    @php
                        $facilityTranslations = [
                            'Wifi' => 'Wi-Fi',
                            'Wi-Fi' => 'Wi-Fi',
                            'AC' => 'AC',
                            'TV Kabel' => 'TV Kabel',
                            'Lift' => 'Lift',
                            'Security 24 Jam' => 'Keamanan 24 Jam',
                            'Balkon' => 'Balkon',
                            'Kolam Renang' => 'Kolam Renang',
                            'Dapur' => 'Dapur',
                            'Taman' => 'Taman',
                            'Furniture' => 'Furnitur',
                            'Pemandangan Sawah' => 'Pemandangan Sawah',
                            'Ruang kerja' => 'Ruang Kerja',
                            'HDTV 45 inci dengan Netflix' => 'HDTV 45 inci dengan Netflix',
                            'Laundry' => 'Layanan Binatu',
                            'CCTV' => 'CCTV',
                            'Parkir Motor' => 'Parkir Motor',
                            'Playground' => 'Area Bermain Anak',
                            'Gym' => 'Pusat Kebugaran (Gym)',
                            'Garasi' => 'Garasi',
                        ];
                    @endphp

                    <div class="facilities-grid" style="margin-top: 1.5rem;">
                        @foreach($facilityList as $facilityName)
                            @php
                                $displayLabel = isset($facilityTranslations[$facilityName]) ? $facilityTranslations[$facilityName] : $facilityName;
                            @endphp
                            <div class="facility-item">
                                <div class="facility-icon">
                                    {!! isset($facilityIcons[$facilityName]) ? $facilityIcons[$facilityName] : $defaultIcon !!}
                                </div>
                                <span>{{ $displayLabel }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Host/Owner Information Section -->
                @php
                    $propertyOwner = \App\Models\User::where('role', 'owner')->first() ?: (object)['name' => 'Pak Hendra (Owner)', 'email' => 'owner@managee.com'];
                    $ownerName = $propertyOwner->name;
                    $ownerEmail = $propertyOwner->email;
                    $ownerInitial = strtoupper(substr($ownerName, 0, 1));
                @endphp
                <section class="host-info-card" style="background-color: var(--bg-light-gray); border: 1px solid var(--border-color); border-radius: 16px; padding: 2rem; margin-top: 2.5rem; display: flex; flex-direction: column; gap: 1.5rem; font-family: 'Outfit', sans-serif;">
                    <h2 class="section-title" style="border-bottom: none; padding-bottom: 0; margin-bottom: 0;">Informasi Pemilik</h2>
                    <div style="display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;">
                        <div style="width: 64px; height: 64px; background-color: var(--secondary-gold); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.75rem; box-shadow: 0 4px 10px rgba(202, 138, 4, 0.15);">
                            <span>{{ $ownerInitial }}</span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <h4 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--emerald-primary);">{{ $ownerName }}</h4>
                                <span style="background-color: var(--emerald-primary); color: white; font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 20px; display: inline-flex; align-items: center; gap: 0.25rem;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Mitra Terverifikasi
                                </span>
                            </div>
                            <span style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500;">Bergabung sejak Maret 2025</span>
                        </div>
                    </div>
                    
                    <p style="margin: 0; font-size: 0.95rem; color: var(--text-slate); line-height: 1.5; font-style: italic;">
                        "Pemilik beberapa properti penginapan premium di wilayah Canggu, Ubud, dan sekitarnya. Fokus memberikan kenyamanan sewa maksimal bagi para wisatawan."
                    </p>

                    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; border-top: 1px solid var(--border-color); padding-top: 1.25rem; font-size: 0.9rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-slate);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--emerald-light);"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>Waktu Respons: <strong>&lt; 1 Jam</strong></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-slate);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--emerald-light);"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Tingkat Balasan: <strong>100%</strong></span>
                        </div>
                    </div>
                    
                    <div>
                        <a href="mailto:{{ $ownerEmail }}?subject=Tanya%20Properti%20{{ rawurlencode($property->title) }}" class="btn-contact-host" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; background-color: var(--emerald-primary); color: white; font-weight: 700; font-size: 0.85rem; padding: 0.65rem 1.25rem; border-radius: 8px; transition: all 0.2s ease; box-shadow: 0 4px 10px rgba(26, 60, 52, 0.15);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            Hubungi Pemilik
                        </a>
                    </div>
                </section>

                <!-- Reviews Section -->
                <section class="reviews-section" style="margin-top: 2.5rem; border-top: 1.5px solid var(--border-color); padding-top: 2rem;">
                    <div class="reviews-header">
                        <h2>Ulasan</h2>
                        @if($totalReviewsCount > 0)
                        <div class="rating-avg">
                            <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            <span>{{ $avgRating }}</span>
                            <span style="color: var(--text-light-slate); font-weight: normal; font-size: 0.85rem;">({{ $totalReviewsCount }} ulasan)</span>
                        </div>
                        @else
                        <span style="color: var(--text-light-slate); font-weight: 500; font-style: italic; font-size: 0.95rem;">(Belum ada ulasan)</span>
                        @endif
                    </div>

                    <div class="review-list">
                        <!-- Database Reviews -->
                        @forelse($dbReviews as $review)
                        <div class="review-item">
                            <div class="review-user-row">
                                <div class="review-user-info">
                                    <div class="review-user-avatar" style="background-color: #047857;">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                                    <div>
                                        <h4 class="review-user-name">{{ $review->user->name }}</h4>
                                        <span class="review-user-date">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="review-stars">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: {{ $i < $review->stars ? 'var(--secondary-gold)' : '#E2E8F0' }}; color: {{ $i < $review->stars ? 'var(--secondary-gold)' : '#E2E8F0' }};"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="review-text">
                                {{ $review->comment }}
                            </p>
                        </div>
                        @empty
                        <p style="font-size: 0.95rem; color: var(--text-light-slate); font-style: italic; margin-bottom: 1.5rem;">Belum ada ulasan untuk properti ini.</p>
                        @endforelse
                    </div>

                    @if($totalReviewsCount > 0)
                    <button class="btn-show-more-reviews" style="margin-bottom: 1rem;" onclick="openReviewsModal()">
                        Tampilkan ke-{{ $totalReviewsCount }} ulasan
                    </button>
                    @endif
                </section>
            </div>

            <!-- Right Column: All-Inclusive tag & Sticky Reservation Form -->
            <div class="content-right">
                
                <!-- All-Inclusive Fee Tag -->
                <div class="all-inclusive-banner">
                    <!-- Red tag SVG icon -->
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span>Harga sudah mencakup seluruh biaya</span>
                </div>

                <!-- Booking Card -->
                <div class="booking-card">
                    <div class="booking-price-header">
                        <span class="booking-price">Rp {{ number_format($property->price, 0, ',', '.') }}</span>
                        <span class="booking-price-period">/ malam</span>
                    </div>

                    <!-- Date & Guests Form -->
                    <div class="booking-form-group">
                        <div class="booking-field">
                            <label for="checkin">Tanggal Masuk</label>
                            <input type="date" id="checkin" class="booking-input" onchange="calculateTotal()">
                        </div>
                        <div class="booking-field">
                            <label for="checkout">Tanggal Keluar</label>
                            <input type="date" id="checkout" class="booking-input" onchange="calculateTotal()">
                        </div>
                        <div class="booking-field">
                            <label for="guests">Jumlah Tamu</label>
                            <select id="guests" class="booking-input">
                                @php
                                    $maxGuests = max(2, $property->bedrooms * 2);
                                @endphp
                                @for ($i = 1; $i <= $maxGuests; $i++)
                                    <option value="{{ $i }}" {{ $i == 2 ? 'selected' : '' }}>{{ $i }} Tamu</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Error Message Block -->
                    <div id="booking-error-msg" style="display: none; color: #ef4444; background: #fee2e2; border: 1px solid #fca5a5; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.25rem; line-height: 1.4;"></div>

                    <!-- Calculations Summary -->
                    <div class="pricing-summary">
                        <div class="pricing-row">
                            <span id="label-nights">Harga Sewa (1 malam)</span>
                            <span id="price-rent">Rp {{ number_format($property->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="pricing-row">
                            <span>Biaya Layanan (10%)</span>
                            <span id="price-service">Rp {{ number_format($property->price * 0.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="pricing-row">
                            <span>Pajak Penginapan (11%)</span>
                            <span id="price-tax">Rp {{ number_format($property->price * 0.11, 0, ',', '.') }}</span>
                        </div>
                        <div class="pricing-row total-row">
                            <span>Total Biaya</span>
                            <span id="price-total">Rp {{ number_format($property->price * 1.21, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Book Now Button -->
                    <button class="btn-submit-booking" onclick="submitBooking()">
                        Pesan Sekarang
                    </button>
                </div>

        </div>

        <!-- Related Properties Section -->
        <section class="related-properties-section">
            <h2 class="related-title">Temukan Properti Serupa</h2>
            
            <div class="related-grid">
                @php
                    $relatedProperties = \App\Models\Property::where('id', '!=', $property->id)->take(3)->get();
                @endphp
                @foreach($relatedProperties as $rel)
                <a href="{{ route('properties.show_public', $rel->id) }}" class="related-card">
                    <img src="{{ $rel->image }}" alt="{{ $rel->title }}" class="related-card-img">
                    <div class="related-card-info">
                        <h3 class="related-card-title">{{ $rel->title }}</h3>
                        <div class="related-card-stars">
                            <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            <span>{{ $rel->reviews->count() > 0 ? number_format($rel->reviews->avg('stars'), 1) : '5.0' }}</span>
                        </div>
                        <p class="related-card-address">{{ $rel->address }}</p>
                        <p class="related-card-price">Rp {{ number_format($rel->price, 0, ',', '.') }} <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light-slate);">/ malam</span></p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

    </div>
</div>

<!-- SweetAlert-like Script for Reservation Handling -->
<script>
    const pricePerNight = {{ $property->price }};

    // Set default checkin date to tomorrow and checkout to day after tomorrow
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const dayAfter = new Date(tomorrow);
        dayAfter.setDate(dayAfter.getDate() + 2); // default 2 nights

        document.getElementById('checkin').value = formatDate(tomorrow);
        document.getElementById('checkout').value = formatDate(dayAfter);
        
        calculateTotal();
    });

    function formatDate(date) {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    function calculateTotal() {
        const checkinInput = document.getElementById('checkin').value;
        const checkoutInput = document.getElementById('checkout').value;
        const errorDiv = document.getElementById('booking-error-msg');

        if (!checkinInput || !checkoutInput) return;

        const checkinDate = new Date(checkinInput);
        const checkoutDate = new Date(checkoutInput);

        // Check if dates are valid
        if (checkoutDate <= checkinDate) {
            errorDiv.textContent = "Tanggal keluar harus setelah tanggal masuk!";
            errorDiv.style.display = 'block';
            
            // Reset checkout to next day
            const nextDay = new Date(checkinDate);
            nextDay.setDate(nextDay.getDate() + 1);
            document.getElementById('checkout').value = formatDate(nextDay);
            calculateTotal();
            return;
        } else {
            errorDiv.style.display = 'none';
        }

        // Calculate nights
        const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
        const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

        // Calculations
        const rentCost = pricePerNight * nights;
        const serviceFee = Math.round(rentCost * 0.1);
        const taxFee = Math.round(rentCost * 0.11);
        const totalCost = rentCost + serviceFee + taxFee;

        // Populate HTML
        document.getElementById('label-nights').textContent = `Harga Sewa (${nights} malam)`;
        document.getElementById('price-rent').textContent = `Rp ` + formatNumber(rentCost);
        document.getElementById('price-service').textContent = `Rp ` + formatNumber(serviceFee);
        document.getElementById('price-tax').textContent = `Rp ` + formatNumber(taxFee);
        document.getElementById('price-total').textContent = `Rp ` + formatNumber(totalCost);
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function submitBooking() {
        const checkin = document.getElementById('checkin').value;
        const checkout = document.getElementById('checkout').value;
        const guests = document.getElementById('guests').value;
        const errorDiv = document.getElementById('booking-error-msg');

        if (!checkin || !checkout) {
            errorDiv.textContent = "Harap tentukan tanggal masuk dan keluar!";
            errorDiv.style.display = 'block';
            return;
        } else {
            errorDiv.style.display = 'none';
        }

        window.location = `/properti/{{ $property->id }}/checkout?checkin=${checkin}&checkout=${checkout}&guests=${guests}`;
    }

    // Modal reviews handlers
    function openReviewsModal() {
        document.getElementById('reviews-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden'; // prevent background scrolling
        // Render initial reviews inside modal when opened
        renderReviews();
    }

    function closeReviewsModal() {
        document.getElementById('reviews-modal').style.display = 'none';
        document.body.style.overflow = 'auto'; // restore background scrolling
    }

    // Close when clicking outside of the modal card
    window.addEventListener('click', (e) => {
        const modal = document.getElementById('reviews-modal');
        if (e.target === modal) {
            closeReviewsModal();
        }
    });

    // Generate 122 reviews list
    const indonesianNames = [
        'Budi Santoso', 'Siti Aminah', 'Rian Hidayat', 'Dewi Lestari', 'Agus Susanto', 
        'Mega Wati', 'Eko Prasetyo', 'Sri Wahyuni', 'Joko Widodo', 'Rina Kartika', 
        'Aditya Pratama', 'Putu Wijaya', 'Gede Suarta', 'Made Devy', 'Ketut Sari', 
        'Nyoman Raka', 'Indah Permata', 'Fajar Nugraha', 'Rizky Amalia', 'Dian Sastro', 
        'Taufik Hidayat', 'Lusi Rahmawati', 'Hendra Wijaya', 'Sari Utami', 'Rudi Hermawan', 
        'Yayan Ruhian', 'Chandra Kirana', 'Novianti', 'Hafiz Pratama', 'Zulfikar', 
        'Bambang', 'Wawan', 'Cecep', 'Asep', 'Dadang', 'Ujang', 'Kurniawan', 'Maman', 
        'Soleh', 'Lukman', 'Joni', 'Toni', 'Doni', 'Roni', 'Dani', 'Beni', 'Gani', 
        'Hadi', 'Yudi', 'Dedi', 'Yansen', 'Christian', 'Kevin', 'Lidya', 'Mei Ling'
    ];

    const foreignNames = [
        'John Doe', 'Sarah Connor', 'Michael Smith', 'Emma Watson', 'Yee Chian', 
        'Chan Laa', 'David Miller', 'James Bond', 'Alice Cooper', 'Bob Dylan', 
        'Charlie Chaplin', 'Emily Dickinson', 'Frank Sinatra', 'Grace Kelly', 
        'Henry Ford', 'Ingrid Bergman', 'Jack London', 'Katherine Hepburn', 
        'Liam Neeson', 'Olivia Wilde', 'Sophia Loren', 'Lucas Pouille', 'Hans Schmidt'
    ];

    const avatarsBg = ['#1E3A8A', '#064E3B', '#701A75', '#B45309', '#0369A1', '#4D7C0F', '#BE185D', '#6D28D9', '#C2410C', '#047857'];

    const templates5 = [
        "Sangat bersih dan nyaman, lokasi strategis sekali dekat pusat perbelanjaan.",
        "Fasilitas lengkap sesuai deskripsi. Kolam renang sangat bersih dan staf ramah.",
        "Pemandangannya luar biasa indah! Terutama saat matahari terbenam. Sangat direkomendasikan.",
        "Akomodasi terbaik selama di Bali. Harganya sepadan dengan fasilitas yang didapat.",
        "Tempat menginap yang luar biasa! Bersih, luas, dan sangat dekat dengan tempat wisata setempat. Nilai 10/10.",
        "Layanan luar biasa dan lokasi sempurna. Kamar bersih, sangat direkomendasikan!",
        "Sangat cocok untuk liburan keluarga. Anak-anak sangat senang dengan kolam renangnya.",
        "Ruang kerjanya nyaman, Wi-Fi kencang, cocok untuk bekerja dari Bali.",
        "Dapurnya lengkap banget, bisa masak-masak santai selama menginap.",
        "Keramahan yang luar biasa! Tuan rumah sangat membantu dan responsif.",
        "Desain interior yang indah. Setiap sudut sangat estetik untuk berfoto. Sangat suka!",
        "Tempatnya tenang sekali, pas buat healing dan menjauh dari keramaian kota.",
        "Kasurnya empuk sekali dan sprei wangi bersih. Tidur jadi sangat nyenyak.",
        "Lokasi dekat pantai, tinggal jalan kaki 5 menit saja. Sempurna!",
        "Proses masuk cepat dan instruksi sangat jelas dari tuan rumah."
    ];

    const templates4 = [
        "Tempatnya bagus dan bersih, hanya saja Wi-Fi kadang agak lambat di malam hari.",
        "Sangat nyaman menginap disini, sayangnya parkir mobil agak sempit.",
        "Lokasi top banget. Sedikit berisik dari luar tapi masih oke untuk tidur.",
        "Bagus sekali, hanya saja AC di ruang tengah kurang dingin dibanding kamar.",
        "Tempat yang bagus, desain yang indah, meskipun pintu kamar mandi agak berderit.",
        "Fasilitas oke dan lengkap, sayangnya handuk yang disediakan agak sedikit kasar.",
        "Tempat strategis dan harga bersahabat, direkomendasikan walau perabotnya agak lama."
    ];

    const templates3 = [
        "Biasa saja. Lokasi bagus tapi kebersihan kamar mandi perlu ditingkatkan.",
        "Fasilitas oke tapi respons tuan rumah agak lambat saat kami masuk.",
        "Lumayan untuk menginap singkat, tapi kasurnya agak keras.",
        "Tempatnya oke, tapi akses jalan masuk ke villa cukup sempit untuk mobil besar."
    ];

    const templates2 = [
        "Kurang memuaskan. AC kurang dingin dan ada kebocoran air di kamar mandi."
    ];

    const templates1 = [
        "Sangat mengecewakan. Kamar tidak bersih saat kami datang dan Wi-Fi mati total."
    ];

    const reviewDates = [
        "2 hari yang lalu", "5 hari yang lalu", "1 minggu yang lalu", "2 minggu yang lalu",
        "3 minggu yang lalu", "1 bulan yang lalu", "2 bulan yang lalu", "3 bulan yang lalu",
        "4 bulan yang lalu", "5 bulan yang lalu", "6 bulan yang lalu", "8 bulan yang lalu"
    ];

    let allReviews = [];
    let currentFilter = 'all';
    let searchQuery = '';

    function generateAllReviews() {
        allReviews = [];
        
        // Add database reviews
        @foreach($dbReviews as $review)
        allReviews.push({
            id: 'db_' + {{ $review->id }},
            name: "{{ addslashes($review->user->name) }}",
            avatarColor: '#047857',
            rating: {{ $review->stars }},
            date: "{{ $review->created_at->diffForHumans() }}",
            comment: "{{ addslashes(str_replace(["\r", "\n"], ' ', $review->comment)) }}"
        });
        @endforeach
    }

    function createMockReview(rating, index) {
        // Use index to deterministically select names, dates, comments
        const isIndonesian = (index % 3 !== 0);
        const nameList = isIndonesian ? indonesianNames : foreignNames;
        const name = nameList[index % nameList.length];
        
        let comment = "";
        if (rating === 5) {
            comment = templates5[index % templates5.length];
        } else if (rating === 4) {
            comment = templates4[index % templates4.length];
        } else if (rating === 3) {
            comment = templates3[index % templates3.length];
        } else if (rating === 2) {
            comment = templates2[index % templates2.length];
        } else {
            comment = templates1[index % templates1.length];
        }
        
        const date = reviewDates[index % reviewDates.length];
        const avatarColor = avatarsBg[index % avatarsBg.length];
        
        return {
            id: index,
            name: name,
            avatarColor: avatarColor,
            rating: rating,
            date: date,
            comment: comment
        };
    }

    // LCG pseudo-random deterministic shuffle
    function shuffleArray(array) {
        let m = array.length, t, i;
        // Seeded random number generator
        let seed = 42;
        function random() {
            let x = Math.sin(seed++) * 10000;
            return x - Math.floor(x);
        }
        while (m) {
            i = Math.floor(random() * m--);
            t = array[m];
            array[m] = array[i];
            array[i] = t;
        }
    }

    function renderReviews() {
        const container = document.getElementById('modal-reviews-container');
        if (!container) return;
        
        container.innerHTML = '';
        
        // Filter reviews
        const filtered = allReviews.filter(rev => {
            const matchesRating = (currentFilter === 'all' || rev.rating === parseInt(currentFilter));
            const matchesSearch = rev.comment.toLowerCase().includes(searchQuery.toLowerCase()) || 
                                  rev.name.toLowerCase().includes(searchQuery.toLowerCase());
            return matchesRating && matchesSearch;
        });

        if (filtered.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 3rem 1rem; color: var(--text-light-slate);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.5; display: inline-block;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    <p style="font-weight: 600; margin: 0;">Tidak ada ulasan ditemukan</p>
                    <p style="font-size: 0.85rem; margin-top: 0.25rem;">Coba gunakan kata kunci atau filter rating yang lain.</p>
                </div>
            `;
            return;
        }

        filtered.forEach(rev => {
            const starsHtml = Array.from({ length: 5 }, (_, i) => {
                const filled = i < rev.rating;
                return `<svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: ${filled ? 'var(--secondary-gold)' : '#E2E8F0'}; color: ${filled ? 'var(--secondary-gold)' : '#E2E8F0'};"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>`;
            }).join('');

            const firstLetter = rev.name.charAt(0).toUpperCase();

            const card = document.createElement('div');
            card.className = 'review-item';
            card.style.borderBottom = '1px solid var(--border-color)';
            card.style.paddingBottom = '1.5rem';
            card.innerHTML = `
                <div class="review-user-row">
                    <div class="review-user-info">
                        <div class="review-user-avatar" style="background-color: ${rev.avatarColor};">${firstLetter}</div>
                        <div>
                            <h4 class="review-user-name">${rev.name}</h4>
                            <span class="review-user-date">${rev.date}</span>
                        </div>
                    </div>
                    <div class="review-stars">
                        ${starsHtml}
                    </div>
                </div>
                <p class="review-text" style="margin-top: 0.75rem;">
                    ${highlightKeyword(rev.comment, searchQuery)}
                </p>
            `;
            container.appendChild(card);
        });
    }

    function highlightKeyword(text, keyword) {
        if (!keyword) return text;
        const regex = new RegExp(`(${keyword})`, 'gi');
        return text.replace(regex, `<mark style="background-color: #FEF08A; color: #1E293B; padding: 0.1rem 0.2rem; border-radius: 4px;">$1</mark>`);
    }

    function setRatingFilter(rating) {
        currentFilter = rating;
        
        // Update active class on pills
        const pills = document.querySelectorAll('.filter-pill');
        pills.forEach(p => {
            if (p.getAttribute('data-rating') === rating.toString()) {
                p.classList.add('active');
            } else {
                p.classList.remove('active');
            }
        });
        
        renderReviews();
    }

    function filterReviews() {
        searchQuery = document.getElementById('review-search').value;
        renderReviews();
    }

    // Call on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', () => {
        generateAllReviews();
        // Render initial reviews inside modal
        renderReviews();
    });
</script>

<!-- Reviews Detail Modal Overlay -->
<div id="reviews-modal" class="reviews-modal-overlay" style="display: none;">
    <div class="reviews-modal-card">
        <div class="reviews-modal-header">
            <div>
                <h3 class="modal-title">Ulasan Properti</h3>
                <p class="modal-subtitle">Total {{ $totalReviewsCount }} ulasan dari penyewa terverifikasi</p>
            </div>
            <button class="reviews-modal-close" onclick="closeReviewsModal()">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        
        <div class="reviews-modal-body">
            <!-- Left Pane: Rating Statistics -->
            <div class="rating-stats-pane">
                <div class="rating-huge-score">
                    <span class="score-num">{{ $avgRating }}</span>
                    <div class="score-stars">
                        <div style="display: flex; gap: 0.15rem; color: var(--secondary-gold); margin-bottom: 0.25rem;">
                            @for($i = 0; $i < 5; $i++)
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $i < round($avgRating) ? 'currentColor' : '#E2E8F0' }}" style="color: {{ $i < round($avgRating) ? 'var(--secondary-gold)' : '#E2E8F0' }}"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            @endfor
                        </div>
                        <span>dari 5 bintang</span>
                    </div>
                </div>
                
                <div class="rating-bars-container">
                    <!-- 5 stars -->
                    <div class="rating-bar-row">
                        <span class="bar-label">5 bintang</span>
                        <div class="bar-bg"><div class="bar-fill" style="width: {{ $stars5Percent }}%;"></div></div>
                        <span class="bar-percent">{{ $stars5Percent }}%</span>
                    </div>
                    <!-- 4 stars -->
                    <div class="rating-bar-row">
                        <span class="bar-label">4 bintang</span>
                        <div class="bar-bg"><div class="bar-fill" style="width: {{ $stars4Percent }}%;"></div></div>
                        <span class="bar-percent">{{ $stars4Percent }}%</span>
                    </div>
                    <!-- 3 stars -->
                    <div class="rating-bar-row">
                        <span class="bar-label">3 bintang</span>
                        <div class="bar-bg"><div class="bar-fill" style="width: {{ $stars3Percent }}%;"></div></div>
                        <span class="bar-percent">{{ $stars3Percent }}%</span>
                    </div>
                    <!-- 2 stars -->
                    <div class="rating-bar-row">
                        <span class="bar-label">2 bintang</span>
                        <div class="bar-bg"><div class="bar-fill" style="width: {{ $stars2Percent }}%;"></div></div>
                        <span class="bar-percent">{{ $stars2Percent }}%</span>
                    </div>
                    <!-- 1 star -->
                    <div class="rating-bar-row">
                        <span class="bar-label">1 bintang</span>
                        <div class="bar-bg"><div class="bar-fill" style="width: {{ $stars1Percent }}%;"></div></div>
                        <span class="bar-percent">{{ $stars1Percent }}%</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Pane: Scrollable List of Reviews & Search/Filters -->
            <div style="display: flex; flex-direction: column; overflow: hidden; width: 100%; height: 100%;">
                <!-- Filter Bar -->
                <div class="reviews-filter-wrapper">
                    <div class="reviews-search-box">
                        <span class="reviews-search-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                        <input type="text" id="review-search" class="reviews-search-input" placeholder="Cari kata kunci di ulasan..." oninput="filterReviews()">
                    </div>
                    <div class="reviews-filter-pills">
                        <button class="filter-pill active" data-rating="all" onclick="setRatingFilter('all')">Semua ({{ $totalReviewsCount }})</button>
                        <button class="filter-pill" data-rating="5" onclick="setRatingFilter(5)">5 ★ ({{ $stars5Count }})</button>
                        <button class="filter-pill" data-rating="4" onclick="setRatingFilter(4)">4 ★ ({{ $stars4Count }})</button>
                        <button class="filter-pill" data-rating="3" onclick="setRatingFilter(3)">3 ★ ({{ $stars3Count }})</button>
                        <button class="filter-pill" data-rating="2" onclick="setRatingFilter(2)">2 ★ ({{ $stars2Count }})</button>
                        <button class="filter-pill" data-rating="1" onclick="setRatingFilter(1)">1 ★ ({{ $stars1Count }})</button>
                    </div>
                </div>

                <div id="modal-reviews-container" class="reviews-list-scrollable" style="flex-grow: 1;">
                    <!-- Dynamically populated via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="gallery-lightbox" class="lightbox-modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(15,23,42,0.6); backdrop-filter:blur(8px); justify-content:center; align-items:center; font-family:'Outfit', sans-serif;">
    <div style="position:relative; background:#FFFFFF; border:1px solid #E2E8F0; border-radius:20px; padding:1.5rem; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); display:flex; flex-direction:column; align-items:center; max-width:90%; width:750px; animation: lightboxScale 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
        
        <!-- Header with Close Button inside the card -->
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:1rem; border-bottom:1px solid #F1F5F9; padding-bottom:0.75rem;">
            <h3 style="margin:0; font-size:1.15rem; font-weight:700; color:var(--emerald-primary);">Galeri Foto</h3>
            <button onclick="closeLightbox()" style="color:var(--text-slate); font-size:24px; font-weight:bold; background:none; border:none; cursor:pointer; padding:0; line-height:1; transition:color 0.2s;" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='var(--text-slate)'">&times;</button>
        </div>
        
        <!-- Main Slide Image Container -->
        <div style="position:relative; width:100%; height:450px; display:flex; justify-content:center; align-items:center; background:#F8FAFC; border-radius:12px; overflow:hidden; border:1px solid #E2E8F0;">
            <!-- Left Arrow -->
            <button onclick="prevLightboxSlide()" style="position:absolute; left:15px; color:var(--emerald-primary); background:#FFFFFF; border:1px solid #E2E8F0; border-radius:50%; width:44px; height:44px; display:flex; justify-content:center; align-items:center; cursor:pointer; z-index:10001; transition:0.2s; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);" onmouseover="this.style.backgroundColor='#F1F5F9'" onmouseout="this.style.backgroundColor='#FFFFFF'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            
            <img id="lightbox-img" src="" style="max-width:100%; max-height:100%; object-fit:contain; user-select:none;">
            
            <!-- Right Arrow -->
            <button onclick="nextLightboxSlide()" style="position:absolute; right:15px; color:var(--emerald-primary); background:#FFFFFF; border:1px solid #E2E8F0; border-radius:50%; width:44px; height:44px; display:flex; justify-content:center; align-items:center; cursor:pointer; z-index:10001; transition:0.2s; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);" onmouseover="this.style.backgroundColor='#F1F5F9'" onmouseout="this.style.backgroundColor='#FFFFFF'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
        
        <!-- Info / Page Indicator -->
        <div id="lightbox-counter" style="color:var(--text-slate); font-size:0.9rem; margin-top:1rem; font-weight:700; background:#F1F5F9; padding:4px 14px; border-radius:20px; border:1px solid #E2E8F0;">1 / 5</div>
    </div>
</div>

<style>
@keyframes lightboxScale {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
</style>

<script>
let lightboxImages = [];
let currentLightboxIndex = 0;

function openLightbox(imagesList, startIndex) {
    lightboxImages = imagesList;
    currentLightboxIndex = startIndex;
    updateLightboxImage();
    const modal = document.getElementById('gallery-lightbox');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Disable page scrolling
}

function closeLightbox() {
    const modal = document.getElementById('gallery-lightbox');
    modal.style.display = 'none';
    document.body.style.overflow = ''; // Restore page scrolling
}

function prevLightboxSlide() {
    if (lightboxImages.length === 0) return;
    currentLightboxIndex = (currentLightboxIndex - 1 + lightboxImages.length) % lightboxImages.length;
    updateLightboxImage();
}

function nextLightboxSlide() {
    if (lightboxImages.length === 0) return;
    currentLightboxIndex = (currentLightboxIndex + 1) % lightboxImages.length;
    updateLightboxImage();
}

function updateLightboxImage() {
    const imgElement = document.getElementById('lightbox-img');
    const counterElement = document.getElementById('lightbox-counter');
    if (imgElement && lightboxImages.length > 0) {
        imgElement.src = lightboxImages[currentLightboxIndex];
        counterElement.textContent = (currentLightboxIndex + 1) + " / " + lightboxImages.length;
    }
}

// Keyboard arrow navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('gallery-lightbox');
    if (modal && modal.style.display === 'flex') {
        if (e.key === 'ArrowLeft') {
            prevLightboxSlide();
        } else if (e.key === 'ArrowRight') {
            nextLightboxSlide();
        } else if (e.key === 'Escape') {
            closeLightbox();
        }
    }
});
</script>
@endsection
