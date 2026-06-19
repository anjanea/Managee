@extends('layouts.app')

@section('title', 'Managee - Pesanan Saya')

@section('content')
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

    .booking-history-container {
        padding-top: 120px;
        padding-bottom: 5rem;
        background-color: var(--bg-light-gray);
        font-family: 'Outfit', sans-serif;
        min-height: 85vh;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--emerald-primary);
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: var(--text-slate);
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }

    .booking-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .booking-card {
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        display: grid;
        grid-template-columns: 240px 1fr;
        transition: all 0.3s ease;
    }

    .booking-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }

    .booking-img-wrapper {
        height: 100%;
        min-height: 200px;
        position: relative;
    }

    .booking-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .booking-details {
        padding: 1.5rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .property-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin: 0 0 0.5rem 0;
        text-decoration: none;
    }

    .property-title:hover {
        color: var(--emerald-light);
    }

    .booking-id {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-light-slate);
        text-transform: uppercase;
        background-color: var(--bg-light-gray);
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        border: 1px solid var(--border-color);
    }

    .booking-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin: 1rem 0;
        padding: 1rem 0;
        border-top: 1px dashed var(--border-color);
        border-bottom: 1px dashed var(--border-color);
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-light-slate);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .booking-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
    }

    .price-tag {
        display: flex;
        flex-direction: column;
    }

    .price-val {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--emerald-primary);
    }

    /* Status Badges */
    .status-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .status-menunggu {
        background-color: #FEF3C7;
        color: #D97706;
        border: 1px solid #FCD34D;
    }

    .status-dikonfirmasi {
        background-color: #DCFCE7;
        color: #15803D;
        border: 1px solid #86EFAC;
    }

    .status-ditolak {
        background-color: #FEE2E2;
        color: #B91C1C;
        border: 1px solid #FCA5A5;
    }

    .status-selesai {
        background-color: #DBEAFE;
        color: #1D4ED8;
        border: 1px solid #93C5FD;
    }

    .empty-state {
        background-color: #FFFFFF;
        border: 1px dashed var(--border-color);
        border-radius: 20px;
        padding: 5rem 2rem;
        text-align: center;
        max-width: 600px;
        margin: 3rem auto;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: var(--bg-light-gray);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light-slate);
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }

    .btn-find-properti {
        background-color: var(--emerald-primary);
        color: #FFFFFF;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(26, 60, 52, 0.15);
        text-decoration: none;
        display: inline-block;
        margin-top: 1.5rem;
    }

    .btn-find-properti:hover {
        background-color: var(--emerald-light);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .booking-card {
            grid-template-columns: 1fr;
        }
        .booking-img-wrapper {
            height: 180px;
            min-height: auto;
        }
        .booking-info-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
    }

    /* Review button and modal styling */
    .btn-review {
        background-color: var(--secondary-gold);
        color: #FFFFFF;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(202, 138, 4, 0.15);
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-family: inherit;
        outline: none;
    }
    .btn-review:hover {
        background-color: var(--secondary-gold-light);
        transform: translateY(-1px);
    }

    /* Modal review style */
    .review-modal-overlay {
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
    .review-modal-card {
        background-color: #FFFFFF;
        border-radius: 20px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        border: 1px solid var(--border-color);
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .review-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .review-modal-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--emerald-primary);
        margin: 0;
    }
    .review-modal-close {
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
    .review-modal-close:hover {
        color: #EF4444;
        background-color: var(--bg-light-gray);
    }
    .star-select-row {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin: 1rem 0;
    }
    .star-select-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        color: #E2E8F0;
        transition: transform 0.1s ease;
        outline: none;
    }
    .star-select-btn:hover {
        transform: scale(1.15);
    }
    .star-select-btn svg {
        width: 36px;
        height: 36px;
        fill: currentColor;
    }
    .star-select-btn.active {
        color: var(--secondary-gold);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

<div class="booking-history-container">
    <div class="container">
        
        <!-- Back Button -->
        <div style="margin-bottom: 1.5rem;">
            <a href="/" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-light-slate); font-size: 0.95rem; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.color='var(--emerald-primary)'" onmouseout="this.style.color='var(--text-light-slate)'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Alerts for feedback -->
        @if(session('success'))
            <div style="background-color: #DEF7EC; border: 1px solid #BCF0DA; color: #03543F; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <h1 class="page-title">Pesanan Saya</h1>
        <p class="page-subtitle">Pantau status konfirmasi pemesanan penginapan Anda di bawah ini</p>

        @if($bookings->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📅</div>
                <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--emerald-primary); margin: 0 0 0.5rem 0;">Belum Ada Pemesanan</h3>
                <p style="color: var(--text-slate); font-size: 0.95rem; margin: 0; line-height: 1.5;">
                    Anda belum melakukan pemesanan properti apa pun di Managee. Temukan tempat menginap terbaik sekarang!
                </p>
                <a href="/properti" class="btn-find-properti">Cari Properti</a>
            </div>
        @else
            <div class="booking-list">
                @foreach($bookings as $booking)
                    <div class="booking-card">
                        <!-- Left pane: Property image -->
                        <div class="booking-img-wrapper">
                            <img src="{{ $booking->property->image ?: 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&q=80&w=600' }}" alt="{{ $booking->property->title }}" class="booking-img">
                        </div>

                        <!-- Right pane: details -->
                        <div class="booking-details">
                            <div>
                                <div class="booking-header">
                                    <a href="/properti/{{ $booking->property->id }}" class="property-title">
                                        {{ $booking->property->title }}
                                    </a>
                                    <span class="booking-id">#ID-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div style="font-size: 0.85rem; color: var(--text-light-slate); margin-top: 0.25rem;">
                                    📍 {{ $booking->property->address }}
                                </div>

                                <div class="booking-info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Tanggal Check-In</span>
                                        <span class="info-value">{{ $booking->checkin_date->translatedFormat('d M Y') }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Tanggal Check-Out</span>
                                        <span class="info-value">{{ $booking->checkout_date->translatedFormat('d M Y') }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Jumlah Tamu</span>
                                        <span class="info-value">{{ $booking->guests }} Tamu</span>
                                    </div>
                                </div>

                                @if(!empty($booking->addons))
                                    <div style="margin-top: 0.5rem;">
                                        <span class="info-label" style="display: block; margin-bottom: 0.25rem;">Layanan Tambahan:</span>
                                        <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                                            @foreach($booking->addons as $key => $addon)
                                                <span style="font-size: 0.75rem; background-color: rgba(45, 106, 79, 0.05); color: var(--emerald-light); padding: 0.25rem 0.5rem; border-radius: 4px; border: 1px solid rgba(45, 106, 79, 0.1); font-weight: 600;">
                                                    + {{ $addon['name'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($booking->review)
                                    <div style="margin-top: 1rem; background-color: #FEF08A; border: 1px solid #FDE047; padding: 0.85rem 1.25rem; border-radius: 12px; font-size: 0.9rem;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; font-weight: 700; color: #854d0e; margin-bottom: 0.25rem;">
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <span>Ulasan Anda:</span>
                                                <div style="display: flex; gap: 0.15rem; color: #CA8A04;">
                                                    @for($i = 0; $i < 5; $i++)
                                                        <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: {{ $i < $booking->review->stars ? '#CA8A04' : '#E2E8F0' }}; color: {{ $i < $booking->review->stars ? '#CA8A04' : '#E2E8F0' }};"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            
                                            <!-- Actions -->
                                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                                <button onclick="openEditReviewModal({{ $booking->review->id }}, {{ $booking->review->stars }}, '{{ addslashes($booking->review->comment) }}', '{{ addslashes($booking->property->title) }}')" style="background: none; border: none; cursor: pointer; color: #854d0e; padding: 0.2rem; display: flex; align-items: center; justify-content: center; transition: transform 0.1s;" title="Edit Ulasan">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </button>
                                                <button onclick="confirmDeleteReview({{ $booking->review->id }}, '{{ addslashes($booking->property->title) }}')" style="background: none; border: none; cursor: pointer; color: #EF4444; padding: 0.2rem; display: flex; align-items: center; justify-content: center; transition: transform 0.1s;" title="Hapus Ulasan">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                </button>
                                            </div>
                                        </div>
                                        @if(trim($booking->review->comment) !== '')
                                            <p style="margin: 0; color: #713f12; font-style: italic; line-height: 1.5; margin-top: 0.25rem;">"{{ $booking->review->comment }}"</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="booking-footer">
                                <div class="price-tag">
                                    <span class="info-label">Total Pembayaran</span>
                                    <span class="price-val">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>

                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    @if($booking->status === 'Selesai' && !$booking->review)
                                        <button class="btn-review" onclick="openReviewModal({{ $booking->id }}, '{{ $booking->property->title }}')">
                                            ✍️ Beri Ulasan
                                        </button>
                                    @endif

                                    @php
                                        $statusClass = 'status-' . strtolower($booking->status);
                                        $statusText = $booking->status;
                                        if ($booking->status === 'Menunggu') $statusText = 'Menunggu Konfirmasi';
                                    @endphp

                                    <span class="status-badge {{ $statusClass }}">
                                        @if($booking->status === 'Menunggu')
                                            🕒
                                        @elseif($booking->status === 'Dikonfirmasi')
                                            ✓
                                        @elseif($booking->status === 'Ditolak')
                                            ✗
                                        @else
                                            ✓
                                        @endif
                                        {{ $statusText }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

<!-- Review Modal Overlay -->
<div id="review-modal" class="review-modal-overlay" style="display: none;">
    <div class="review-modal-card">
        <div class="review-modal-header">
            <h3 class="review-modal-title">Beri Ulasan</h3>
            <button class="review-modal-close" onclick="closeReviewModal()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        
        <form id="review-form" action="" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
            @csrf
            <input type="hidden" name="_method" id="review-form-method" value="POST">
            
            <p style="color: var(--text-slate); font-size: 0.9rem; margin: 0; line-height: 1.4;">
                Bagikan pengalaman menginap Anda di <strong id="modal-property-title"></strong>. Masukan Anda sangat berharga bagi calon penyewa lain.
            </p>
            
            <div style="text-align: center;">
                <label style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); display: block; margin-bottom: 0.5rem; text-transform: uppercase;">
                    Rating Bintang
                </label>
                <div class="star-select-row">
                    <button type="button" class="star-select-btn" data-star="1" onclick="setStarRating(1)">
                        <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </button>
                    <button type="button" class="star-select-btn" data-star="2" onclick="setStarRating(2)">
                        <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </button>
                    <button type="button" class="star-select-btn" data-star="3" onclick="setStarRating(3)">
                        <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </button>
                    <button type="button" class="star-select-btn" data-star="4" onclick="setStarRating(4)">
                        <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </button>
                    <button type="button" class="star-select-btn" data-star="5" onclick="setStarRating(5)">
                        <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </button>
                </div>
                <!-- Hidden input for rating -->
                <input type="hidden" name="stars" id="input-stars-val" value="5">
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="review-comment" style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); text-transform: uppercase;">
                    Tulis Ulasan Anda (Opsional)
                </label>
                <textarea id="review-comment" name="comment" rows="4" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color); border-radius: 10px; font-family: inherit; font-size: 0.95rem; outline: none; transition: border-color 0.2s; resize: vertical;" placeholder="Tuliskan pengalaman Anda secara detail di sini (opsional)..."></textarea>
            </div>
            
            <button type="submit" class="btn-review" style="width: 100%; justify-content: center; padding: 0.85rem; font-size: 0.95rem;">
                <span id="review-submit-text">Kirim Ulasan</span>
            </button>
        </form>
    </div>
</div>

<!-- Centered Deletion Modal for Reviews -->
<div id="delete-review-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: #FFFFFF; border-radius: 16px; padding: 2rem; max-width: 450px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); text-align: center; border: 1px solid var(--border-color); animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <!-- Warning Icon -->
        <div style="background: #FEE2E2; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem auto; color: #EF4444;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>

        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--emerald-primary); margin-bottom: 0.5rem; font-family: 'Outfit';">Konfirmasi Hapus Ulasan</h3>
        <p style="font-size: 0.9rem; color: var(--text-slate); line-height: 1.5; margin-bottom: 1.75rem;">
            Apakah Anda yakin ingin menghapus ulasan Anda untuk properti <strong id="delete-review-property" style="color: var(--text-dark);"></strong>? Tindakan ini tidak dapat dibatalkan.
        </p>

        <!-- Hidden Form -->
        <form id="delete-review-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 0.75rem; justify-content: center;">
                <button type="button" onclick="closeDeleteReviewModal()" style="background-color: #FFFFFF; color: var(--text-slate); border: 1px solid var(--text-slate); font-family: inherit; font-size: 0.9rem; font-weight: 700; padding: 0.65rem 1.5rem; border-radius: 8px; cursor: pointer; width: 100%; transition: all 0.2s ease;">
                    Batal
                </button>
                <button type="submit" style="background-color: #EF4444; color: #FFFFFF; border: none; font-family: inherit; font-size: 0.9rem; font-weight: 700; padding: 0.65rem 1.5rem; border-radius: 8px; cursor: pointer; width: 100%; transition: all 0.2s ease; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentRating = 5;

    function openReviewModal(bookingId, propertyTitle) {
        document.querySelector('.review-modal-title').textContent = 'Beri Ulasan';
        document.getElementById('review-submit-text').textContent = 'Kirim Ulasan';
        document.getElementById('review-form-method').value = 'POST';
        document.getElementById('modal-property-title').textContent = propertyTitle;
        document.getElementById('review-form').action = "{{ url('/pesanan') }}/" + bookingId + "/ulasan";
        
        // Reset modal fields
        setStarRating(5);
        document.getElementById('review-comment').value = '';
        
        document.getElementById('review-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function openEditReviewModal(reviewId, stars, comment, propertyTitle) {
        document.querySelector('.review-modal-title').textContent = 'Ubah Ulasan';
        document.getElementById('review-submit-text').textContent = 'Simpan Perubahan';
        document.getElementById('review-form-method').value = 'PUT';
        document.getElementById('modal-property-title').textContent = propertyTitle;
        document.getElementById('review-form').action = "{{ url('/ulasan') }}/" + reviewId;
        
        // Populate fields
        setStarRating(stars);
        document.getElementById('review-comment').value = comment;
        
        document.getElementById('review-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeReviewModal() {
        document.getElementById('review-modal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function setStarRating(rating) {
        currentRating = rating;
        document.getElementById('input-stars-val').value = rating;
        
        // Highlight active stars
        const buttons = document.querySelectorAll('.star-select-btn');
        buttons.forEach(btn => {
            const val = parseInt(btn.getAttribute('data-star'));
            if (val <= rating) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    function confirmDeleteReview(reviewId, propertyTitle) {
        document.getElementById('delete-review-property').textContent = `"${propertyTitle}"`;
        document.getElementById('delete-review-form').action = "{{ url('/ulasan') }}/" + reviewId;
        document.getElementById('delete-review-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteReviewModal() {
        document.getElementById('delete-review-modal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close on click overlay outside card
    window.addEventListener('click', (e) => {
        const modal = document.getElementById('review-modal');
        const deleteModal = document.getElementById('delete-review-modal');
        if (e.target === modal) {
            closeReviewModal();
        } else if (e.target === deleteModal) {
            closeDeleteReviewModal();
        }
    });
</script>
@endsection
