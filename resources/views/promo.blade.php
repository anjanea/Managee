@extends('layouts.app')

@section('title', 'Managee - Kupon Promo & Penawaran Spesial')

@section('content')

<div class="container" style="padding: 3rem 1rem; min-height: 70vh;">
    <!-- Back to Home Button -->
    <div style="margin-bottom: 1.5rem;">
        <a href="/" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; font-size: 0.95rem; font-weight: 600; color: var(--text-muted); transition: var(--transition);" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

    <!-- Breadcrumbs -->
    <div style="margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">
        <a href="/" style="color: var(--text-muted); text-decoration: none; transition: var(--transition);">Beranda</a>
        <span style="margin: 0 0.5rem;">/</span>
        <span style="color: var(--primary); font-weight: 600;">Promo</span>
    </div>

    <!-- Header Section -->
    <div style="margin-bottom: 2.5rem;">
        <h1 style="font-size: 2.25rem; font-weight: 700; color: var(--primary); margin: 0 0 0.5rem 0;">Kupon Promo & Diskon</h1>
        <p style="margin: 0; color: var(--text-muted); font-size: 1rem;">Temukan penawaran terbaik dan gunakan kode promo saat memesan untuk mendapatkan potongan harga spesial.</p>
    </div>

    <!-- Filter & Tabs Row -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
        <!-- Filter Tabs -->
        <div style="display: flex; gap: 1rem;">
            <button onclick="switchTab('aktif')" id="tab-aktif" style="background: none; border: none; font-size: 1rem; font-weight: 700; color: var(--primary); border-bottom: 3px solid var(--primary); padding-bottom: 0.5rem; cursor: pointer; transition: var(--transition);">Promo Aktif</button>
            <button onclick="switchTab('berakhir')" id="tab-berakhir" style="background: none; border: none; font-size: 1rem; font-weight: 600; color: var(--text-muted); border-bottom: 3px solid transparent; padding-bottom: 0.5rem; cursor: pointer; transition: var(--transition);">Sudah Berakhir</button>
        </div>
        
        <!-- Search bar -->
        <div style="display: flex; align-items: center; gap: 0.5rem; border: 1px solid var(--border); padding: 0.5rem 1rem; border-radius: var(--radius-md); background: var(--bg-light); width: 100%; max-width: 320px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" id="promo-search" oninput="searchPromos()" placeholder="Cari kode promo..." style="background: none; border: none; outline: none; width: 100%; font-family: inherit; font-size: 0.9rem;">
        </div>
    </div>

    <!-- Active Promos Container -->
    <div id="promos-aktif-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
        <!-- Card 1 -->
        <div class="promo-card-item" data-code="EARLYBIRD20" style="background: linear-gradient(135deg, var(--primary) 0%, #0c201a 100%); color: white; border-radius: var(--radius-lg); padding: 1.75rem; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; height: 190px; box-shadow: var(--shadow-md); border-left: 6px solid var(--secondary); transition: var(--transition);">
            <div style="position: absolute; left: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
            <div style="position: absolute; right: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
            
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <span style="background: rgba(255,255,255,0.2); font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.5rem; border-radius: 4px; text-transform: uppercase;">Semua Properti</span>
                        <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.75rem; font-weight: 700; color: var(--secondary);">Diskon 20%</h3>
                    </div>
                    <span style="font-size: 2rem; opacity: 0.25;">🏷️</span>
                </div>
                <p style="margin: 0; font-size: 0.85rem; color: #cbd5e1; line-height: 1.4;">Dapatkan potongan 20% tanpa minimum transaksi untuk semua pemesanan properti. Berlaku s.d. 15 Jul 2026.</p>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed rgba(255,255,255,0.2); padding-top: 0.75rem; margin-top: 0.5rem;">
                <code style="font-family: monospace; font-size: 1.25rem; font-weight: 700; color: white; letter-spacing: 1px;">EARLYBIRD20</code>
                <button onclick="copyPromo('EARLYBIRD20', this)" style="background: white; color: var(--primary); border: none; padding: 0.45rem 1rem; border-radius: var(--radius-sm); font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: var(--transition);">Salin Kode</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="promo-card-item" data-code="WEEKENDSERU" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white; border-radius: var(--radius-lg); padding: 1.75rem; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; height: 190px; box-shadow: var(--shadow-md); border-left: 6px solid #fbbf24; transition: var(--transition);">
            <div style="position: absolute; left: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
            <div style="position: absolute; right: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
            
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <span style="background: rgba(255,255,255,0.15); font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.5rem; border-radius: 4px; text-transform: uppercase; color: #fbbf24;">Khusus Villa Canggu</span>
                        <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.75rem; font-weight: 700; color: #fbbf24;">Diskon 10%</h3>
                    </div>
                    <span style="font-size: 2rem; opacity: 0.25;">🌴</span>
                </div>
                <p style="margin: 0; font-size: 0.85rem; color: #94a3b8; line-height: 1.4;">Nikmati liburan akhir pekan hemat khusus di unit mewah Villa Canggu. Berlaku s.d. 30 Jun 2026.</p>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed rgba(255,255,255,0.15); padding-top: 0.75rem; margin-top: 0.5rem;">
                <code style="font-family: monospace; font-size: 1.25rem; font-weight: 700; color: white; letter-spacing: 1px;">WEEKENDSERU</code>
                <button onclick="copyPromo('WEEKENDSERU', this)" style="background: #fbbf24; color: #0f172a; border: none; padding: 0.45rem 1rem; border-radius: var(--radius-sm); font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: var(--transition);">Salin Kode</button>
            </div>
        </div>
    </div>

    <!-- Expired Promos Container (Hidden by default) -->
    <div id="promos-berakhir-grid" style="display: none; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
        <!-- Card 3 (Expired) -->
        <div class="promo-card-item" data-code="PROMOHEMAT" style="background: #f1f5f9; color: #94a3b8; border-radius: var(--radius-lg); padding: 1.75rem; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; height: 190px; border: 1px solid var(--border); border-left: 6px solid #cbd5e1;">
            <div style="position: absolute; left: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
            <div style="position: absolute; right: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
            
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <span style="background: #e2e8f0; font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.5rem; border-radius: 4px; text-transform: uppercase; color: #64748b;">Rumah Modern Ubud</span>
                        <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.75rem; font-weight: 700; color: #64748b;">Diskon 15%</h3>
                    </div>
                    <span style="font-size: 2rem; opacity: 0.15; filter: grayscale(1);">🏠</span>
                </div>
                <p style="margin: 0; font-size: 0.85rem; color: #94a3b8; line-height: 1.4;">Promo hemat sewa harian/mingguan di Rumah Modern Ubud. Berakhir 31 Jan 2026.</p>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed #cbd5e1; padding-top: 0.75rem; margin-top: 0.5rem;">
                <code style="font-family: monospace; font-size: 1.25rem; font-weight: 700; color: #94a3b8; text-decoration: line-through; letter-spacing: 1px;">PROMOHEMAT</code>
                <span style="background: #e2e8f0; color: #64748b; padding: 0.45rem 1rem; border-radius: var(--radius-sm); font-size: 0.8rem; font-weight: 700;">Kedaluwarsa</span>
            </div>
        </div>
    </div>
    
    <!-- Empty State -->
    <div id="promo-empty" style="display: none; text-align: center; padding: 4rem 1rem; color: var(--text-muted);">
        <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">🔍</span>
        <h3 style="margin: 0; color: var(--primary);">Kupon tidak ditemukan</h3>
        <p style="margin: 0.25rem 0 0 0; font-size: 0.9rem;">Coba masukkan kata kunci pencarian yang lain.</p>
    </div>
</div>

<script>
    let activeTab = 'aktif';

    function switchTab(tab) {
        activeTab = tab;
        const btnAktif = document.getElementById('tab-aktif');
        const btnBerakhir = document.getElementById('tab-berakhir');
        
        const gridAktif = document.getElementById('promos-aktif-grid');
        const gridBerakhir = document.getElementById('promos-berakhir-grid');

        if (tab === 'aktif') {
            btnAktif.style.color = 'var(--primary)';
            btnAktif.style.borderBottomColor = 'var(--primary)';
            btnBerakhir.style.color = 'var(--text-muted)';
            btnBerakhir.style.borderBottomColor = 'transparent';
            
            gridAktif.style.display = 'grid';
            gridBerakhir.style.display = 'none';
        } else {
            btnBerakhir.style.color = 'var(--primary)';
            btnBerakhir.style.borderBottomColor = 'var(--primary)';
            btnAktif.style.color = 'var(--text-muted)';
            btnAktif.style.borderBottomColor = 'transparent';
            
            gridAktif.style.display = 'none';
            gridBerakhir.style.display = 'grid';
        }

        // Re-run search/filter to apply correctly to new tab
        searchPromos();
    }

    function searchPromos() {
        const query = document.getElementById('promo-search').value.toUpperCase().trim();
        const activeGridId = activeTab === 'aktif' ? 'promos-aktif-grid' : 'promos-berakhir-grid';
        const activeGrid = document.getElementById(activeGridId);
        const cards = activeGrid.querySelectorAll('.promo-card-item');
        const emptyState = document.getElementById('promo-empty');
        
        let visibleCount = 0;

        cards.forEach(card => {
            const code = card.getAttribute('data-code');
            if (code.includes(query)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Toggle empty state
        if (visibleCount === 0) {
            activeGrid.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            activeGrid.style.display = 'grid';
            emptyState.style.display = 'none';
        }
    }

    function copyPromo(code, button) {
        navigator.clipboard.writeText(code).then(() => {
            const originalText = button.textContent;
            button.textContent = 'Tersalin!';
            button.style.background = '#22c55e';
            button.style.color = 'white';
            
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = code === 'EARLYBIRD20' ? 'white' : '#fbbf24';
                button.style.color = code === 'EARLYBIRD20' ? 'var(--primary)' : '#0f172a';
            }, 2000);
        }).catch(err => {
            alert('Gagal menyalin kode: ' + err);
        });
    }
</script>

@endsection
