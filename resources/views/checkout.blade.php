@extends('layouts.app')

@section('title', 'Managee - Pembayaran')

@section('content')
<!-- Custom Checkout Styles -->
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

    .checkout-page-container {
        padding-top: 100px; /* Offset for fixed navbar */
        padding-bottom: 5rem;
        background-color: var(--bg-light-gray);
        font-family: 'Outfit', sans-serif;
        min-height: 90vh;
    }

    /* Steps Tracker */
    .steps-tracker {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text-light-slate);
    }

    .step-item.active {
        color: var(--emerald-primary);
        font-weight: 700;
    }

    .step-number {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: #E2E8F0;
        color: var(--text-slate);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .step-item.active .step-number {
        background-color: var(--emerald-primary);
        color: #FFFFFF;
    }

    .step-item.completed .step-number {
        background-color: #22C55E;
        color: #FFFFFF;
    }

    .step-line {
        height: 2px;
        width: 60px;
        background-color: #E2E8F0;
    }

    .step-line.active {
        background-color: var(--emerald-primary);
    }

    /* Two-Column Checkout Layout */
    .checkout-layout {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 2.5rem;
        align-items: flex-start;
    }

    .checkout-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        margin-bottom: 1.5rem;
    }

    .checkout-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin: 0 0 0.5rem 0;
    }

    .checkout-subtitle {
        font-size: 0.9rem;
        color: var(--text-light-slate);
        margin: 0 0 1.5rem 0;
    }

    /* Form Fields */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-bottom: 1.25rem;
    }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .form-input {
        width: 100%;
        padding: 0.8rem 1.5rem;
        font-family: inherit;
        font-size: 0.95rem;
        color: var(--text-dark);
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 9999px;
        outline: none;
        transition: all 0.25s ease;
    }

    .form-input:focus {
        border-color: var(--emerald-light);
        background-color: #FFFFFF;
        box-shadow: 0 0 0 3px var(--emerald-glow);
    }

    /* Add-ons List (Step 2) */
    .addon-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .addon-item:hover {
        border-color: var(--emerald-light);
        background-color: rgba(45, 106, 79, 0.01);
    }

    .addon-item.selected {
        border-color: var(--emerald-light);
        background-color: rgba(45, 106, 79, 0.03);
    }

    .addon-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .addon-checkbox {
        width: 20px;
        height: 20px;
        accent-color: var(--emerald-light);
        cursor: pointer;
    }

    .addon-details h4 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--emerald-primary);
    }

    .addon-details p {
        margin: 0.15rem 0 0 0;
        font-size: 0.8rem;
        color: var(--text-slate);
    }

    .addon-price {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--secondary-gold);
    }

    /* Payment Methods Grid (Step 3) */
    .payment-options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .payment-card {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        background-color: #FFFFFF;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .payment-card:hover {
        border-color: var(--emerald-light);
        background-color: rgba(45, 106, 79, 0.01);
    }

    .payment-card.selected {
        border-color: var(--emerald-light);
        background-color: rgba(45, 106, 79, 0.04);
        box-shadow: 0 0 0 2px var(--emerald-light);
    }

    .payment-card-icon {
        font-size: 1.75rem;
    }

    .payment-card-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--emerald-primary);
    }

    /* Sub-payment panels */
    .payment-panel {
        background-color: var(--bg-light-gray);
        border: 1px dashed var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Summary Pane (Right side) */
    .summary-pane {
        position: sticky;
        top: 100px;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .summary-card {
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
    }

    .summary-property-row {
        display: flex;
        gap: 1rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 1.25rem;
    }

    .summary-property-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        background-color: #E2E8F0;
    }

    .summary-property-info h3 {
        margin: 0 0 0.25rem 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--emerald-primary);
    }

    .summary-property-info p {
        margin: 0;
        font-size: 0.8rem;
        color: var(--text-slate);
        line-height: 1.3;
    }

    .summary-details-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--text-slate);
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 1rem;
    }

    .summary-details-item {
        display: flex;
        justify-content: space-between;
    }

    .summary-details-item .val {
        font-weight: 600;
        color: var(--text-dark);
    }

    /* Promo input */
    .coupon-wrapper {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .coupon-input {
        flex: 1;
        padding: 0.6rem 0.85rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        outline: none;
        font-family: inherit;
        font-size: 0.85rem;
    }

    .coupon-btn {
        background-color: var(--emerald-primary);
        color: white;
        border: none;
        padding: 0 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .coupon-btn:hover {
        background-color: var(--emerald-light);
    }

    /* Final bottom total banner card inside summary-pane */
    .bottom-cta-banner {
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
    }

    .bottom-cta-container {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 1.25rem;
    }

    .bottom-left-details {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .bottom-total-row {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .bottom-total-label {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .bottom-total-price {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--secondary-gold);
    }

    .btn-checkout-next {
        width: 100%;
        background-color: var(--secondary-gold);
        color: white;
        border: none;
        padding: 1rem 3rem;
        font-family: inherit;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(202, 138, 4, 0.2);
    }

    .btn-checkout-next:hover {
        background-color: var(--secondary-gold-light);
        transform: translateY(-1px);
    }

    /* Success Card Overlay */
    .success-card {
        text-align: center;
        padding: 3rem 2rem;
        background-color: #FFFFFF;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        max-width: 500px;
        margin: 4rem auto;
    }

    .success-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #DCFCE7;
        color: #16A34A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1.5rem auto;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
        .summary-pane {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .bottom-cta-banner {
            padding: 1.25rem 1.5rem;
        }
        .bottom-cta-container {
            flex-direction: column;
            align-items: stretch;
            gap: 1.25rem;
        }
        .bottom-total-row {
            justify-content: space-between;
            width: 100%;
        }
        .bottom-total-price {
            font-size: 1.5rem;
        }
        .btn-checkout-next {
            padding: 0.85rem 2rem;
            font-size: 1.05rem;
        }
        #points-notice {
            margin-top: 0.5rem;
            text-align: center;
        }
        .bottom-left-details {
            width: 100%;
        }
    }
</style>

<div class="checkout-page-container">
    <div class="container" style="max-width: 1100px;">
        
        <!-- STEPS TRACKER -->
        <div class="steps-tracker">
            <div id="step-track-1" class="step-item active">
                <div class="step-number">1</div>
                <span>Detail Pesanan</span>
            </div>
            <div id="step-line-1" class="step-line"></div>
            <div id="step-track-2" class="step-item">
                <div class="step-number">2</div>
                <span>Pelengkap Menginap</span>
            </div>
            <div id="step-line-2" class="step-line"></div>
            <div id="step-track-3" class="step-item">
                <div class="step-number">3</div>
                <span>Metode Pembayaran</span>
            </div>
        </div>

        <!-- MAIN LAYOUT -->
        <div id="checkout-main-grid" class="checkout-layout">
            
            <!-- LEFT WIZARD PANE -->
            <div class="wizard-left-pane">
                
                <!-- STEP 1: DETAIL GUEST FORM -->
                <div id="step-form-1" class="checkout-card">
                    <h2 class="checkout-title">Detail Pesanan</h2>
                    <p class="checkout-subtitle">Lengkapi detailnya dengan datamu untuk keperluan pemesanan</p>
                    
                    <div class="form-group">
                        <label for="full-name">Nama Lengkap <span style="color: #E53E3E;">*</span></label>
                        <input type="text" id="full-name" class="form-input" placeholder="Masukkan nama lengkap" oninput="this.value = this.value.replace(/[^a-zA-Z\s']/g, '')">
                    </div>
                    <div class="form-group">
                        <label for="email-addr">Alamat Email <span style="color: #E53E3E;">*</span></label>
                        <input type="email" id="email-addr" class="form-input" placeholder="email@contoh.com">
                        <span style="font-size: 0.75rem; color: var(--text-light-slate); margin-top: 0.15rem; margin-left: 1rem;">Email konfirmasi akan dikirim ke alamat ini</span>
                    </div>
                    <div class="form-group">
                        <label for="phone-num">Nomor Telepon <span style="color: #E53E3E;">*</span></label>
                        <input type="text" id="phone-num" class="form-input" placeholder="Contoh: +628123456789" oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
                        <span style="font-size: 0.75rem; color: var(--text-light-slate); margin-top: 0.15rem; margin-left: 1rem;">Untuk memverifikasi pemesanan Anda, dan agar akomodasi dapat menghubungi jika diperlukan</span>
                    </div>
                </div>

                <!-- STEP 2: ADD-ONS SELECTION -->
                <div id="step-form-2" class="checkout-card" style="display: none;">
                    <h2 class="checkout-title">Pelengkap Menginap</h2>
                    <p class="checkout-subtitle">Tambahkan kenyamanan ekstra untuk petualangan menginap Anda</p>
                    
                    <!-- Add-on 1 -->
                    <div class="addon-item" onclick="toggleAddon('insurance', 45000, this)">
                        <div class="addon-left">
                            <input type="checkbox" id="addon-insurance" class="addon-checkbox" pointer-events="none">
                            <div class="addon-details">
                                <h4>Asuransi Perjalanan Aman</h4>
                                <p>Jaminan perlindungan keterlambatan, pembatalan, dan kerusakan bagasi.</p>
                            </div>
                        </div>
                        <div class="addon-price">Rp 45.000</div>
                    </div>

                    <!-- Add-on 2 -->
                    <div class="addon-item" onclick="toggleAddon('pickup', 150000, this)">
                        <div class="addon-left">
                            <input type="checkbox" id="addon-pickup" class="addon-checkbox" pointer-events="none">
                            <div class="addon-details">
                                <h4>Penjemputan Bandara</h4>
                                <p>Pengemudi ramah siap menyambut Anda langsung di Terminal Kedatangan.</p>
                            </div>
                        </div>
                        <div class="addon-price">Rp 150.000</div>
                    </div>

                    <!-- Add-on 3 -->
                    <div class="addon-item" onclick="toggleAddon('breakfast', 80000, this)">
                        <div class="addon-left">
                            <input type="checkbox" id="addon-breakfast" class="addon-checkbox" pointer-events="none">
                            <div class="addon-details">
                                <h4>Sarapan Harian Khas Bali</h4>
                                <p>Menu sarapan lezat khas Bali diantar ke kamar Anda setiap pagi.</p>
                            </div>
                        </div>
                        <div class="addon-price">Rp 80.000 / malam</div>
                    </div>
                </div>

                <!-- STEP 3: PAYMENT METHOD -->
                <div id="step-form-3" class="checkout-card" style="display: none;">
                    <h2 class="checkout-title">Pilih Metode Pembayaran</h2>
                    <p class="checkout-subtitle">Pilih metode transaksi pembayaran yang aman dan nyaman bagi Anda</p>
                    
                    <div class="payment-options-grid">
                        <div class="payment-card selected" onclick="selectPaymentMethod('bank', this)">
                            <div class="payment-card-icon">🏦</div>
                            <div class="payment-card-title">Transfer Bank</div>
                        </div>
                        <div class="payment-card" onclick="selectPaymentMethod('qris', this)">
                            <div class="payment-card-icon">📱</div>
                            <div class="payment-card-title">QRIS Instan</div>
                        </div>
                        <div class="payment-card" onclick="selectPaymentMethod('card', this)">
                            <div class="payment-card-icon">💳</div>
                            <div class="payment-card-title">Kartu Debit/Kredit</div>
                        </div>
                    </div>

                    <!-- Bank Transfer Sub-Panel -->
                    <div id="panel-bank" class="payment-panel">
                        <h4 style="margin: 0 0 1rem 0; font-size: 0.95rem; color: var(--emerald-primary);">Pilih Bank Virtual Account (VA)</h4>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                                <input type="radio" name="bank-select" value="BCA" checked style="accent-color: var(--emerald-light);">
                                <span>BCA Virtual Account</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                                <input type="radio" name="bank-select" value="Mandiri" style="accent-color: var(--emerald-light);">
                                <span>Mandiri Virtual Account</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                                <input type="radio" name="bank-select" value="BNI" style="accent-color: var(--emerald-light);">
                                <span>BNI Virtual Account</span>
                            </label>
                        </div>
                    </div>

                    <!-- QRIS Sub-Panel -->
                    <div id="panel-qris" class="payment-panel" style="display: none; text-align: center;">
                        <h4 style="margin: 0 0 0.5rem 0; font-size: 0.95rem; color: var(--emerald-primary);">Scan Kode QRIS</h4>
                        <p style="font-size: 0.8rem; color: var(--text-slate); margin-bottom: 1rem;">Gunakan GoPay, OVO, ShopeePay, atau Mobile Banking Anda</p>
                        <!-- Mock QR Code SVG -->
                        <div style="background-color: white; padding: 1rem; border-radius: 8px; display: inline-block; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 0.5rem;">
                            <svg width="150" height="150" viewBox="0 0 100 100" fill="currentColor">
                                <rect x="0" y="0" width="30" height="30" />
                                <rect x="5" y="5" width="20" height="20" fill="white" />
                                <rect x="10" y="10" width="10" height="10" />
                                <rect x="70" y="0" width="30" height="30" />
                                <rect x="75" y="5" width="20" height="20" fill="white" />
                                <rect x="80" y="10" width="10" height="10" />
                                <rect x="0" y="70" width="30" height="30" />
                                <rect x="5" y="75" width="20" height="20" fill="white" />
                                <rect x="10" y="80" width="10" height="10" />
                                <rect x="40" y="40" width="20" height="20" />
                                <rect x="45" y="45" width="10" height="10" fill="white" />
                                <rect x="80" y="80" width="20" height="20" />
                                <rect x="50" y="10" width="10" height="15" />
                                <rect x="15" y="50" width="15" height="10" />
                                <rect x="80" y="50" width="10" height="20" />
                            </svg>
                        </div>
                        <p style="font-size: 0.75rem; color: var(--text-light-slate); font-weight: 700;">Kode QR akan kedaluwarsa dalam 15:00 menit</p>
                    </div>

                    <!-- Credit Card Sub-Panel -->
                    <div id="panel-card" class="payment-panel" style="display: none;">
                        <h4 style="margin: 0 0 1rem 0; font-size: 0.95rem; color: var(--emerald-primary);">Informasi Kartu Debit / Kredit</h4>
                        <div class="form-group">
                            <label for="cc-num" style="font-size: 0.75rem;">Nomor Kartu</label>
                            <input type="text" id="cc-num" class="form-input" style="padding: 0.6rem 0.85rem;" placeholder="0000 0000 0000 0000">
                        </div>
                        <div style="display: flex; gap: 1rem;">
                            <div class="form-group" style="flex: 1;">
                                <label for="cc-exp" style="font-size: 0.75rem;">Masa Berlaku</label>
                                <input type="text" id="cc-exp" class="form-input" style="padding: 0.6rem 0.85rem;" placeholder="MM/YY">
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label for="cc-cvv" style="font-size: 0.75rem;">CVV</label>
                                <input type="password" id="cc-cvv" class="form-input" style="padding: 0.6rem 0.85rem;" placeholder="***">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT SUMMARY PANE -->
            <div class="summary-pane">
                
                <!-- Order Summary Card -->
                <div class="summary-card">
                    <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--emerald-primary); margin-bottom: 1.25rem;">Ringkasan Pemesanan</h2>
                    
                    <!-- Property Details Info Row -->
                    <div class="summary-property-row">
                        <img src="{{ $property->image }}" alt="{{ $property->title }}" class="summary-property-img">
                        <div class="summary-property-info">
                            <h3>{{ $property->title }}</h3>
                            <p>{{ $property->address }}</p>
                        </div>
                    </div>

                    <!-- Stay detail data items -->
                    <div class="summary-details-list">
                        <div class="summary-details-item">
                            <span>Check-in:</span>
                            <span class="val" id="summary-checkin-val">Sab, 23 Mei 2026</span>
                        </div>
                        <div class="summary-details-item">
                            <span>Check-out:</span>
                            <span class="val" id="summary-checkout-val">Sel, 26 Mei 2026</span>
                        </div>
                        <div class="summary-details-item">
                            <span>Tamu:</span>
                            <span class="val">{{ $guests }} orang</span>
                        </div>
                    </div>

                    <!-- Coupon Code Input (Requested Promo Handling) -->
                    <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.35rem; text-transform: uppercase;">Miliki Kode Promo?</div>
                    <div class="coupon-wrapper">
                        <input type="text" id="coupon-code-input" class="coupon-input" placeholder="Masukkan kode promo">
                        <button class="coupon-btn" onclick="applyCoupon()">Terapkan</button>
                    </div>
                    <div id="coupon-alert" style="font-size: 0.8rem; font-weight: 600; margin-bottom: 1rem; display: none;"></div>

                    <!-- Pricing breakdown calculation -->
                    <div style="display: flex; flex-direction: column; gap: 0.6rem; border-top: 1px solid var(--border-color); padding-top: 1.25rem; font-size: 0.85rem; color: var(--text-slate);">
                        <div class="summary-details-item">
                            <span id="summary-nights-label">Harga dasar (1 malam)</span>
                            <span id="summary-base-price">Rp 0</span>
                        </div>
                        <div class="summary-details-item">
                            <span>Biaya layanan (10%)</span>
                            <span id="summary-service-fee">Rp 0</span>
                        </div>
                        <div class="summary-details-item">
                            <span>Pajak (5%)</span>
                            <span id="summary-tax-fee">Rp 0</span>
                        </div>
                        <!-- Add-ons Price Row (Dynamic) -->
                        <div class="summary-details-item" id="summary-addons-row" style="display: none;">
                            <span>Layanan Tambahan</span>
                            <span id="summary-addons-price">Rp 0</span>
                        </div>
                        <!-- Discount Row (Dynamic) -->
                        <div class="summary-details-item" id="summary-discount-row" style="display: none; color: #22C55E; font-weight: 600;">
                            <span id="discount-label">Diskon (0%)</span>
                            <span id="summary-discount-price">-Rp 0</span>
                        </div>
                    </div>

                    <!-- Summary Card Total Row matching mockup -->
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; border-top: 1px solid var(--border-color); padding-top: 1rem; margin-top: 1rem;">
                        <div>
                            <span style="font-weight: 700; color: var(--text-dark); font-size: 0.95rem;">Total</span>
                            <div id="summary-savings-val" style="font-size: 0.8rem; color: #22C55E; font-weight: 700; margin-top: 0.15rem; display: none;">Hemat Rp 0</div>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-weight: 800; color: var(--secondary-gold); font-size: 1.15rem;" id="summary-total-val">Rp 0</span>
                            <div id="summary-original-val" style="font-size: 0.8rem; color: var(--text-light-slate); text-decoration: line-through; display: none; margin-top: 0.1rem;">Rp 0</div>
                        </div>
                    </div>
                </div>

                <!-- BOTTOM TOTAL BANNER -->
                <div class="bottom-cta-banner">
                    <div class="bottom-cta-container">
                        <!-- Row 1: Totals -->
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                            <div class="bottom-left-details">
                                <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--emerald-primary); margin: 0;">Total Bayar</h3>
                                <div id="bottom-savings" style="font-size: 0.9rem; color: #22C55E; font-weight: 700; margin-top: 0.25rem; display: none;">Hemat Rp 0</div>
                            </div>
                            <div style="text-align: right;">
                                <div class="bottom-total-price" id="bottom-total-price" style="font-size: 1.8rem; font-weight: 800; color: var(--secondary-gold);">Rp 0</div>
                                <div id="bottom-original-price" style="font-size: 0.85rem; color: var(--text-light-slate); text-decoration: line-through; display: none; margin-top: 0.15rem;">Rp 0</div>
                            </div>
                        </div>

                        <!-- Row 2: Action Buttons (Lanjutkan & Batal/Kembali) -->
                        <div style="display: flex; gap: 1rem; width: 100%; margin-top: 0.5rem; margin-bottom: 0.5rem;">
                            <!-- Back/Cancel Button -->
                            <button id="btn-wizard-back" class="btn-checkout-cancel" onclick="goBackOrCancel()" style="flex: 1; background-color: transparent; color: var(--text-slate); border: 2px solid var(--border-color); padding: 1rem 1.5rem; font-family: inherit; font-size: 1rem; font-weight: 700; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; text-align: center;">
                                Batal
                            </button>
                            
                            <!-- Next/Pay Button -->
                            <button id="btn-wizard-cta" class="btn-checkout-next" onclick="advanceStep()" style="flex: 2; width: auto; margin-top: 0;">
                                Lanjutkan
                            </button>
                        </div>

                        <!-- Row 3: Cashback Notice -->
                        <div style="font-size: 0.85rem; color: var(--text-light-slate); font-weight: 500; text-align: left; margin-top: -0.25rem;" id="points-notice">
                            Hore! Kamu dapet cashback <span id="cashback-pts" style="color: var(--emerald-light); font-weight: 700;">0</span> poin.
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- SUCCESS CARD OVERLAY (Hidden by default) -->
        <div id="checkout-success-view" class="success-card" style="display: none;">
            <div class="success-icon">✓</div>
            <h2 style="font-size: 1.75rem; color: var(--emerald-primary); font-weight: 700; margin-bottom: 0.5rem;">Pembayaran Sukses!</h2>
            <p style="color: var(--text-slate); font-size: 0.95rem; line-height: 1.5; margin-bottom: 2rem;">
                Pemesanan properti Anda berhasil diverifikasi. Bukti bayar dan voucher inap telah dikirimkan ke alamat email Anda.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <button class="btn-checkout-next" onclick="window.location='/'" style="background-color: var(--emerald-primary); padding: 0.85rem 1.5rem; font-size: 0.95rem; width: auto;">
                    Kembali ke Beranda
                </button>
                <button class="btn-checkout-next" onclick="window.location='/pesanan'" style="background-color: var(--secondary-gold); padding: 0.85rem 1.5rem; font-size: 0.95rem; width: auto; box-shadow: none;">
                    Lihat Pesanan Saya
                </button>
            </div>
        </div>

        <!-- Hidden Form for DB storage -->
        <form id="db-booking-form" action="{{ route('user.bookings.store', $property->id) }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="checkin" id="form-checkin">
            <input type="hidden" name="checkout" id="form-checkout">
            <input type="hidden" name="guests" id="form-guests">
            <input type="hidden" name="total_price" id="form-total-price">
            
            <input type="checkbox" name="addon_insurance" id="form-addon-insurance" value="1">
            <input type="checkbox" name="addon_pickup" id="form-addon-pickup" value="1">
            <input type="checkbox" name="addon_breakfast" id="form-addon-breakfast" value="1">
        </form>

    </div>
</div>

<!-- JavaScript Wizard & Dynamic Calculations Logic -->
<script>
    // State Database
    const pricePerNight = {{ $property->price }};
    const checkinParam = "{{ $checkin }}";
    const checkoutParam = "{{ $checkout }}";
    const guestsParam = {{ $guests }};

    let activeStep = 1;
    let selectedAddons = {
        insurance: false,
        pickup: false,
        breakfast: false
    };
    let addonPrices = {
        insurance: 45000,
        pickup: 150000,
        breakfast: 80000 // per night
    };
    let activePromoDiscount = 0; // percentage
    let activePromoLabel = '';
    let nightsCount = 1;

    // Load initial parameters and execute calculations
    document.addEventListener('DOMContentLoaded', () => {
        // Parse dates to show formatted labels in summary
        const inDate = new Date(checkinParam);
        const outDate = new Date(checkoutParam);
        
        document.getElementById('summary-checkin-val').textContent = formatNiceDate(inDate);
        document.getElementById('summary-checkout-val').textContent = formatNiceDate(outDate);

        // Calculate nights
        const timeDiff = outDate.getTime() - inDate.getTime();
        nightsCount = Math.ceil(timeDiff / (1000 * 3600 * 24));
        if (nightsCount < 1) nightsCount = 1;

        calculateCosts();
    });

    function formatNiceDate(date) {
        const options = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    function calculateCosts() {
        const baseCost = pricePerNight * nightsCount;
        
        // Addons Cost
        let addonsCost = 0;
        if (selectedAddons.insurance) addonsCost += addonPrices.insurance;
        if (selectedAddons.pickup) addonsCost += addonPrices.pickup;
        if (selectedAddons.breakfast) addonsCost += addonPrices.breakfast * nightsCount;

        // Discount Cost
        const discountAmount = Math.round(baseCost * (activePromoDiscount / 100));

        // Net Base Cost
        const netBaseCost = baseCost - discountAmount;

        // Taxes & Fees based on net price
        const serviceFee = Math.round(netBaseCost * 0.10);
        const taxFee = Math.round(netBaseCost * 0.05); // 5% matching mockup exactly

        const totalCost = netBaseCost + serviceFee + taxFee + addonsCost;
        const originalTotalCost = baseCost + Math.round(baseCost * 0.10) + Math.round(baseCost * 0.05) + addonsCost;

        // Populate Summary Fields
        document.getElementById('summary-nights-label').textContent = `Harga dasar (${nightsCount} malam)`;
        document.getElementById('summary-base-price').textContent = `Rp ` + formatNumber(baseCost);
        document.getElementById('summary-service-fee').textContent = `Rp ` + formatNumber(serviceFee);
        document.getElementById('summary-tax-fee').textContent = `Rp ` + formatNumber(taxFee);

        // Handle Addons visibility in summary
        if (addonsCost > 0) {
            document.getElementById('summary-addons-row').style.display = 'flex';
            document.getElementById('summary-addons-price').textContent = `Rp ` + formatNumber(addonsCost);
        } else {
            document.getElementById('summary-addons-row').style.display = 'none';
        }

        // Handle Discount visibility in summary
        if (discountAmount > 0) {
            document.getElementById('summary-discount-row').style.display = 'flex';
            document.getElementById('discount-label').textContent = `Diskon (${activePromoLabel} ${activePromoDiscount}%)`;
            document.getElementById('summary-discount-price').textContent = `-Rp ` + formatNumber(discountAmount);

            // Update Total banner discount Crossed Prices
            document.getElementById('bottom-original-price').style.display = 'inline-block';
            document.getElementById('bottom-original-price').textContent = `Rp ` + formatNumber(originalTotalCost);
            
            document.getElementById('bottom-savings').style.display = 'block';
            document.getElementById('bottom-savings').textContent = `Hemat Rp ` + formatNumber(discountAmount);

            // Update Summary Total values (Mockup match)
            document.getElementById('summary-savings-val').style.display = 'block';
            document.getElementById('summary-savings-val').textContent = `Hemat Rp ` + formatNumber(discountAmount);
            document.getElementById('summary-original-val').style.display = 'block';
            document.getElementById('summary-original-val').textContent = `Rp ` + formatNumber(originalTotalCost);
        } else {
            document.getElementById('summary-discount-row').style.display = 'none';
            document.getElementById('bottom-original-price').style.display = 'none';
            document.getElementById('bottom-savings').style.display = 'none';

            // Reset Summary Total values
            document.getElementById('summary-savings-val').style.display = 'none';
            document.getElementById('summary-original-val').style.display = 'none';
        }

        // Final Total Pay
        document.getElementById('bottom-total-price').textContent = `Rp ` + formatNumber(totalCost);
        document.getElementById('summary-total-val').textContent = `Rp ` + formatNumber(totalCost);

        // Dynamic points calculation (mockup formula e.g. totalCost / 612 rounded or similar)
        const pointsEarned = Math.round(totalCost / 612);
        document.getElementById('cashback-pts').textContent = formatNumber(pointsEarned);
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Toggle Addon (Step 2)
    function toggleAddon(type, price, element) {
        selectedAddons[type] = !selectedAddons[type];
        
        const checkbox = document.getElementById(`addon-${type}`);
        checkbox.checked = selectedAddons[type];

        if (selectedAddons[type]) {
            element.classList.add('selected');
        } else {
            element.classList.remove('selected');
        }

        calculateCosts();
    }

    // Apply Coupon Code Action
    function applyCoupon() {
        const input = document.getElementById('coupon-code-input').value.toUpperCase().trim();
        const alertBox = document.getElementById('coupon-alert');

        if (input === 'EARLYBIRD20') {
            activePromoDiscount = 20;
            activePromoLabel = 'EARLYBIRD20';
            alertBox.style.display = 'block';
            alertBox.style.color = '#22C55E';
            alertBox.textContent = '✓ Promo EARLYBIRD20 berhasil diterapkan! Diskon 20%.';
        } else if (input === 'WEEKENDSERU') {
            activePromoDiscount = 10;
            activePromoLabel = 'WEEKENDSERU';
            alertBox.style.display = 'block';
            alertBox.style.color = '#22C55E';
            alertBox.textContent = '✓ Promo WEEKENDSERU berhasil diterapkan! Diskon 10%.';
        } else if (input === '') {
            activePromoDiscount = 0;
            activePromoLabel = '';
            alertBox.style.display = 'none';
        } else {
            activePromoDiscount = 0;
            activePromoLabel = '';
            alertBox.style.display = 'block';
            alertBox.style.color = '#E53E3E';
            alertBox.textContent = '✗ Kode promo tidak valid atau telah kedaluwarsa.';
        }

        calculateCosts();
    }

    // Select Payment Method (Step 3)
    function selectPaymentMethod(method, element) {
        document.querySelectorAll('.payment-card').forEach(card => card.classList.remove('selected'));
        element.classList.add('selected');

        // Toggle sub-panels visibility
        document.getElementById('panel-bank').style.display = method === 'bank' ? 'block' : 'none';
        document.getElementById('panel-qris').style.display = method === 'qris' ? 'block' : 'none';
        document.getElementById('panel-card').style.display = method === 'card' ? 'block' : 'none';
    }

    // Wizard Navigation Controller
    function advanceStep() {
        if (activeStep === 1) {
            const nameInput = document.getElementById('full-name');
            const emailInput = document.getElementById('email-addr');
            const phoneInput = document.getElementById('phone-num');

            const name = nameInput.value.trim();
            const email = emailInput.value.trim();
            const phone = phoneInput.value.trim();

            if (!name || !email || !phone) {
                alert("Harap lengkapi semua kolom bertanda bintang (*) untuk melanjutkan!");
                return;
            }

            if (name.length < 2) {
                alert("Nama Lengkap harus berisi minimal 2 karakter!");
                nameInput.focus();
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Format alamat email tidak valid (contoh: nama@email.com)!");
                emailInput.focus();
                return;
            }

            const cleanPhone = phone.replace(/[^0-9]/g, '');
            if (cleanPhone.length < 9 || cleanPhone.length > 15) {
                alert("Nomor telepon harus berisi antara 9 sampai 15 digit angka!");
                phoneInput.focus();
                return;
            }

            // Move to Step 2
            document.getElementById('step-form-1').style.display = 'none';
            document.getElementById('step-form-2').style.display = 'block';
            
            document.getElementById('step-track-1').className = 'step-item completed';
            document.getElementById('step-line-1').className = 'step-line active';
            document.getElementById('step-track-2').className = 'step-item active';

            document.getElementById('btn-wizard-back').textContent = 'Kembali';

            activeStep = 2;
            window.scrollTo({ top: 0, behavior: 'smooth' });

        } else if (activeStep === 2) {
            // Move to Step 3
            document.getElementById('step-form-2').style.display = 'none';
            document.getElementById('step-form-3').style.display = 'block';

            document.getElementById('step-track-2').className = 'step-item completed';
            document.getElementById('step-line-2').className = 'step-line active';
            document.getElementById('step-track-3').className = 'step-item active';

            document.getElementById('btn-wizard-cta').textContent = 'Bayar Sekarang';
            document.getElementById('btn-wizard-back').textContent = 'Kembali';
            
            activeStep = 3;
            window.scrollTo({ top: 0, behavior: 'smooth' });

        } else if (activeStep === 3) {
            // Populate and submit form to DB
            document.getElementById('form-checkin').value = checkinParam;
            document.getElementById('form-checkout').value = checkoutParam;
            document.getElementById('form-guests').value = guestsParam;
            
            // Extract numerical value from total price label
            const totalText = document.getElementById('summary-total-val').textContent;
            const cleanTotal = parseInt(totalText.replace(/[^0-9]/g, ''));
            document.getElementById('form-total-price').value = cleanTotal;

            // Mark addon checkboxes
            document.getElementById('form-addon-insurance').checked = selectedAddons.insurance;
            document.getElementById('form-addon-pickup').checked = selectedAddons.pickup;
            document.getElementById('form-addon-breakfast').checked = selectedAddons.breakfast;

            // Disable button & show loading state
            const btn = document.getElementById('btn-wizard-cta');
            btn.disabled = true;
            btn.textContent = 'Memproses Pembayaran...';

            // Submit via AJAX (fetch) to record in DB and show success/failure cards
            const form = document.getElementById('db-booking-form');
            const formData = new FormData(form);

            // Simulating payment process
            setTimeout(() => {
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Hide main grid & steps tracker
                        document.getElementById('checkout-main-grid').style.display = 'none';
                        document.querySelector('.steps-tracker').style.display = 'none';
                        
                        // Show success card view
                        document.getElementById('checkout-success-view').style.display = 'block';
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    } else {
                        throw new Error("Gagal menyimpan pemesanan");
                    }
                })
                .catch(error => {
                    // Simulate Payment Failure
                    alert("Pembayaran Gagal: Saldo kartu Anda tidak mencukupi atau koneksi pembayaran ke Virtual Account/QRIS terputus. Silakan ganti kartu atau coba metode pembayaran lain.");
                    btn.disabled = false;
                    btn.textContent = 'Bayar Sekarang';
                });
            }, 1500); // 1.5s simulated delay for premium feel
        }
    }

    // Wizard Back or Cancel Controller
    function goBackOrCancel() {
        if (activeStep === 1) {
            // Cancel booking, go back to property detail page
            if (confirm("Apakah Anda yakin ingin membatalkan pemesanan properti ini?")) {
                window.location.href = '/properti/{{ $property->id }}';
            }
        } else if (activeStep === 2) {
            // Go back to step 1
            document.getElementById('step-form-2').style.display = 'none';
            document.getElementById('step-form-1').style.display = 'block';
            
            document.getElementById('step-track-1').className = 'step-item active';
            document.getElementById('step-line-1').className = 'step-line';
            document.getElementById('step-track-2').className = 'step-item';
            
            document.getElementById('btn-wizard-back').textContent = 'Batal';
            
            activeStep = 1;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else if (activeStep === 3) {
            // Go back to step 2
            document.getElementById('step-form-3').style.display = 'none';
            document.getElementById('step-form-2').style.display = 'block';
            
            document.getElementById('step-track-2').className = 'step-item active';
            document.getElementById('step-line-2').className = 'step-line';
            document.getElementById('step-track-3').className = 'step-item';
            
            document.getElementById('btn-wizard-cta').textContent = 'Lanjutkan';
            document.getElementById('btn-wizard-back').textContent = 'Kembali';
            
            activeStep = 2;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
</script>
@endsection
