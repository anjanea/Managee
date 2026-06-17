@extends('layouts.app')

@section('title', 'Managee - Pusat Bantuan Penyewa')

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

    .help-page-container {
        padding-top: 120px;
        padding-bottom: 5rem;
        background-color: var(--bg-light-gray);
        font-family: 'Outfit', sans-serif;
        min-height: 85vh;
    }

    .help-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 3rem auto;
    }

    .help-title {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--emerald-primary);
        margin-bottom: 0.5rem;
    }

    .help-subtitle {
        color: var(--text-slate);
        font-size: 1rem;
        line-height: 1.5;
    }

    .help-content-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 3rem;
        max-width: 1000px;
        margin: 0 auto;
        align-items: flex-start;
    }

    /* Side navigation tabs */
    .help-tabs {
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }

    .help-tab-btn {
        width: 100%;
        text-align: left;
        background: none;
        border: none;
        padding: 0.75rem 1rem;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-slate);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .help-tab-btn:hover {
        background-color: var(--bg-light-gray);
        color: var(--emerald-primary);
    }

    .help-tab-btn.active {
        background-color: var(--emerald-glow);
        color: var(--emerald-primary);
    }

    /* FAQ accordion container */
    .faq-container {
        display: none;
        flex-direction: column;
        gap: 1rem;
    }

    .faq-container.active {
        display: flex;
    }

    .faq-group-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin: 0 0 1rem 0;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 0.5rem;
    }

    .faq-item {
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.01);
        transition: all 0.25s ease;
    }

    .faq-question-btn {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: none;
        border: none;
        padding: 1.25rem 1.5rem;
        font-family: inherit;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        text-align: left;
        cursor: pointer;
        outline: none;
    }

    .faq-question-btn svg {
        transition: transform 0.2s ease;
        flex-shrink: 0;
        color: var(--text-light-slate);
    }

    .faq-item.open {
        border-color: var(--emerald-light);
        box-shadow: 0 5px 15px var(--emerald-glow);
    }

    .faq-item.open .faq-question-btn svg {
        transform: rotate(180deg);
        color: var(--emerald-light);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.25s cubic-bezier(0, 1, 0, 1);
        background-color: #FFFFFF;
    }

    .faq-answer-inner {
        padding: 0 1.5rem 1.25rem 1.5rem;
        color: var(--text-slate);
        font-size: 0.95rem;
        line-height: 1.6;
        border-top: 1px solid var(--border-color);
        padding-top: 1rem;
    }

    @media (max-width: 768px) {
        .help-content-layout {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }
</style>

<div class="help-page-container">
    <div class="container">
        
        <!-- Back Button -->
        <div style="max-width: 1000px; margin: 0 auto 1.5rem auto;">
            <a href="/" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-light-slate); font-size: 0.95rem; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.color='var(--emerald-primary)'" onmouseout="this.style.color='var(--text-light-slate)'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <header class="help-header">
            <h1 class="help-title">Pusat Bantuan Penyewa</h1>
            <p class="help-subtitle">
                Temukan solusi dan jawaban cepat mengenai pemesanan, pembayaran, serta aturan penginapan Anda di platform Managee.
            </p>
        </header>

        <div class="help-content-layout">
            <!-- Left Pane: Tabs Navigation & Contact Info -->
            <aside style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div class="help-tabs">
                    <button class="help-tab-btn active" onclick="switchCategory('status', this)">
                        📅 Pemesanan & Status
                    </button>
                    <button class="help-tab-btn" onclick="switchCategory('pembayaran', this)">
                        💳 Pembayaran & Biaya
                    </button>
                    <button class="help-tab-btn" onclick="switchCategory('kebijakan', this)">
                        📋 Kebijakan & Pengembalian
                    </button>
                    <button class="help-tab-btn" onclick="switchCategory('kendala', this)">
                        ⚠️ Masalah & Bantuan
                    </button>
                </div>

                <!-- Contact Support Card -->
                <div style="background-color: #FFFFFF; border: 1px solid var(--border-color); border-radius: 16px; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);">
                    <div style="background: rgba(26, 60, 52, 0.05); color: var(--emerald-primary); width: 44px; height: 44px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                        🛠️
                    </div>
                    <div>
                        <h4 style="margin: 0 0 0.25rem 0; color: var(--emerald-primary); font-size: 0.95rem; font-weight: 700;">Butuh bantuan cepat?</h4>
                        <p style="margin: 0; font-size: 0.8rem; color: var(--text-slate); line-height: 1.4;">Tim Layanan Pelanggan Managee siap mendampingi kendala Anda 24/7.</p>
                    </div>
                    
                    <div style="border-top: 1px solid var(--border-color); padding-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.85rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.15rem;">
                            <span style="color: var(--text-light-slate);">Surel Bantuan:</span>
                            <strong style="color: var(--emerald-primary); font-size: 0.95rem;">support@managee.id</strong>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.15rem;">
                            <span style="color: var(--text-light-slate);">Kontak WA:</span>
                            <strong style="color: var(--emerald-primary); font-size: 0.95rem;">0812-8899-7766</strong>
                        </div>
                    </div>
 
                    <button onclick="alert('Layanan obrolan langsung penyewa sedang dipersiapkan!')" style="background: var(--secondary-gold); color: white; border: none; padding: 0.65rem; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; text-align: center; font-family: inherit; width: 100%;" onmouseover="this.style.backgroundColor='var(--secondary-gold-light)'" onmouseout="this.style.backgroundColor='var(--secondary-gold)'">Hubungi Obrolan Langsung</button>
                </div>
            </aside>

            <!-- Right Pane: Accordion Content -->
            <main class="help-faq-content">
                
                <!-- Category 1: Pemesanan & Status -->
                <div id="cat-status" class="faq-container active">
                    <h2 class="faq-group-title">Pemesanan & Status</h2>
                    
                    <!-- Q1 -->
                    <div class="faq-item">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>Bagaimana cara mengetahui apakah pesanan saya sudah dikonfirmasi?</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Anda dapat memantau status pesanan secara langsung di halaman <strong>Pesanan Saya</strong>. Status pemesanan akan dilabeli dengan ikon jam kuning 🕒 <em>Menunggu Konfirmasi</em> jika belum ditinjau oleh pemilik, dan akan berubah menjadi tanda centang hijau ✓ <em>Dikonfirmasi</em> jika telah disetujui. Notifikasi status juga dikirimkan melalui email terdaftar Anda.
                            </div>
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div class="faq-item">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>Mengapa pesanan saya masih berstatus "Menunggu Konfirmasi"?</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Setiap pemilik properti diberikan waktu maksimal 24 jam untuk meninjau dan menerima permintaan pemesanan Anda. Jika pemilik tidak merespons dalam 24 jam, pesanan akan dibatalkan secara otomatis oleh sistem demi keamanan dana Anda.
                            </div>
                        </div>
                    </div>

                    <!-- Q3 -->
                    <div class="faq-item">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>Apa yang harus saya lakukan jika status pesanan saya ditolak?</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Jika pemesanan ditolak oleh pemilik (misalnya karena berbenturan dengan pemeliharaan unit atau pemesanan offline), dana yang sudah Anda bayar akan dikembalikan secara utuh 100% ke metode pembayaran asal Anda. Anda dapat langsung mencari opsi properti lain yang serupa di platform kami.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 2: Pembayaran & Biaya -->
                <div id="cat-pembayaran" class="faq-container">
                    <h2 class="faq-group-title">Pembayaran & Biaya</h2>
                    
                    <!-- Q4 -->
                    <div class="faq-item">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>Apakah total harga pembayaran sudah mencakup seluruh biaya?</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Ya. Seluruh properti di platform Managee memiliki kebijakan "Biaya Menyeluruh (All-Inclusive)". Harga total yang Anda bayar di halaman checkout sudah mencakup biaya sewa kamar, biaya layanan platform, pajak penginapan daerah, serta layanan tambahan yang Anda pilih secara sukarela. Tidak ada biaya tersembunyi saat Anda tiba di lokasi.
                            </div>
                        </div>
                    </div>

                    <!-- Q5 -->
                    <div class="faq-item">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>Metode pembayaran apa saja yang tersedia?</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Kami menyediakan beberapa metode pembayaran instan dan aman, diantaranya:
                                <ul>
                                    <li>Transfer Bank Virtual Account (BCA, Mandiri, BNI, BRI)</li>
                                    <li>Pembayaran Instan QRIS (Gopay, OVO, Dana, ShopeePay, LinkAja)</li>
                                    <li>Kartu Kredit & Debit Internasional (Visa, Mastercard, JCB)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 3: Kebijakan & Refund -->
                <div id="cat-kebijakan" class="faq-container">
                    <h2 class="faq-group-title">Kebijakan & Pembatalan</h2>
                    
                    <!-- Q6 -->
                    <div class="faq-item">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>Bagaimana cara membatalkan pemesanan saya?</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Pembatalan dapat diajukan dengan menghubungi Pusat Bantuan kami atau mengirim pesan melalui formulir pengajuan dengan menyertakan Nomor Pesanan (#ID) Anda. Harap diperhatikan bahwa pengajuan pembatalan terikat pada Kebijakan Pembatalan properti yang bersangkutan.
                            </div>
                        </div>
                    </div>

                    <!-- Q7 -->
                    <div class="faq-item">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>Apakah saya berhak mendapatkan pengembalian dana?</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Pengembalian dana penuh (100%) berlaku jika pembatalan diajukan selambat-lambatnya 48 jam sebelum jadwal masuk. Pembatalan yang dilakukan kurang dari 48 jam sebelum masuk akan dikenakan biaya pembatalan sebesar tarif malam pertama.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 4: Masalah & Bantuan -->
                <div id="cat-kendala" class="faq-container">
                    <h2 class="faq-group-title">Masalah & Kendala Menginap</h2>
                    
                    <!-- Q8 -->
                    <div class="faq-item">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>Siapa yang harus saya hubungi jika terjadi kendala saat proses masuk?</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Setelah pesanan Anda berstatus <strong>Dikonfirmasi</strong>, Anda akan diberikan kontak telepon langsung pemilik properti yang dapat dihubungi via panggilan atau WhatsApp untuk koordinasi kedatangan. Jika Anda kesulitan menghubungi pemilik, hubungi Layanan Pelanggan Managee di <em>support@managee.id</em>.
                            </div>
                        </div>
                    </div>
 
                    <!-- Q9 -->
                    <div class="faq-item">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>Bagaimana jika fasilitas di properti tidak sesuai dengan deskripsi?</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                Demi perlindungan kenyamanan bersama, Managee menerapkan kebijakan <em>Menginap Aman (Safe-Stay)</em>. Dana sewa Anda ditahan oleh sistem kami dan baru diteruskan ke pemilik properti 2 hari (H+2) setelah keluar. Jika properti sangat tidak sesuai deskripsi saat Anda datang, segera kirimkan bukti foto/video kepada Layanan Pelanggan kami dalam kurun waktu 24 jam pertama setelah masuk untuk mengajukan pemindahan penginapan atau pembekuan transaksi dana.
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>

    </div>
</div>

<script>
    function switchCategory(catId, btnElement) {
        // Remove active class from all tab buttons
        document.querySelectorAll('.help-tab-btn').forEach(btn => btn.classList.remove('active'));
        
        // Hide all FAQ containers
        document.querySelectorAll('.faq-container').forEach(container => container.classList.remove('active'));
        
        // Set active status
        btnElement.classList.add('active');
        document.getElementById('cat-' + catId).classList.add('active');

        // Close any open accordion items in newly active category
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('open');
            const answer = item.querySelector('.faq-answer');
            answer.style.maxHeight = null;
        });
    }

    function toggleFaq(btnElement) {
        const item = btnElement.parentElement;
        const answer = item.querySelector('.faq-answer');

        if (item.classList.contains('open')) {
            item.classList.remove('open');
            answer.style.maxHeight = null;
        } else {
            // Close other items in the same container first (optional accordion behavior)
            const parent = item.parentElement;
            parent.querySelectorAll('.faq-item').forEach(otherItem => {
                otherItem.classList.remove('open');
                otherItem.querySelector('.faq-answer').style.maxHeight = null;
            });

            item.classList.add('open');
            answer.style.maxHeight = answer.scrollHeight + "px";
        }
    }
</script>
@endsection
