@extends('layouts.app')

@section('title', 'Managee')

@section('content')

<!-- Hero Section -->
<section class="hero" style="padding-top: 180px; padding-bottom: 130px; background: linear-gradient(rgba(17, 42, 36, 0.82), rgba(17, 42, 36, 0.82)), url('{{ asset('hero-bg.jpg') }}') center/cover no-repeat;">
    <div class="container">
        <div class="hero-container">
            <h1>Temukan Properti Impianmu</h1>
            <p>Temukan apartemen, rumah, atau vila sempurna untuk gaya hidup Anda bersama Managee.</p>
            
            <form action="{{ route('properties.index') }}" method="GET" class="search-container" style="max-width: 650px; padding: 0.5rem 1rem; min-height: auto;">
                <div class="search-field" style="position: relative;">
                    <label for="lokasi">Pencarian</label>
                    <div style="position: relative; display: flex; align-items: center; width: 100%;">
                        <input type="text" name="search" id="lokasi" value="{{ request('search') }}" placeholder="Cari properti..." style="width: 100%; padding-right: 1.5rem; border: none; outline: none; background: transparent; font-family: inherit; font-size: 0.9rem;">
                        <span id="clear-lokasi-beranda" style="position: absolute; right: 0; cursor: pointer; color: var(--text-muted); font-weight: bold; font-size: 1.2rem; display: {{ request('search') ? 'inline-block' : 'none' }}; line-height: 1; transition: var(--transition);" onclick="clearBerandaSearch()">×</span>
                    </div>
                </div>
                <div class="search-field">
                    <label for="kategori">Kategori</label>
                    <select name="type" id="kategori">
                        <option value="all">Semua Tipe</option>
                        <option value="apartemen">Apartemen</option>
                        <option value="rumah">Rumah</option>
                        <option value="villa">Villa</option>
                    </select>
                </div>
                <button type="submit" class="search-btn" style="width: 40px; height: 40px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </button>
            </form>

            <script>
            function clearBerandaSearch() {
                const input = document.getElementById('lokasi');
                const btn = document.getElementById('clear-lokasi-beranda');
                if (input) {
                    input.value = '';
                    input.focus();
                }
                if (btn) {
                    btn.style.display = 'none';
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                const input = document.getElementById('lokasi');
                const btn = document.getElementById('clear-lokasi-beranda');
                if (input && btn) {
                    input.addEventListener('input', () => {
                        btn.style.display = input.value.trim() !== '' ? 'inline-block' : 'none';
                    });
                }
            });
            </script>
        </div>
    </div>
</section>

<!-- Featured Properties Section (Properti Unggulan) -->
<section class="section" style="padding-top: 2.5rem; padding-bottom: 1rem;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
            <div class="section-header" style="margin-bottom: 0;">
                <h2>Properti Unggulan</h2>
                <p style="margin-bottom: 0;">Pilihan terbaik untuk Anda</p>
            </div>
            <a href="{{ route('properties.index') }}" style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.95rem; font-weight: 600; color: var(--primary); text-decoration: none; transition: var(--transition);" onmouseover="this.style.color='var(--secondary)'" onmouseout="this.style.color='var(--primary)'">
                <span>Lihat Semua</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>

        <div class="property-grid">
            @foreach($featuredProperties as $prop)
            <div class="property-card" style="cursor: pointer;" onclick="window.location='{{ route('properties.show_public', $prop->id) }}'">
                <div class="property-img-wrapper">
                    <img src="{{ $prop->image }}" alt="{{ $prop->title }}" class="property-img">
                </div>
                <div class="property-content">
                    <h3 class="property-title">{{ $prop->title }}</h3>
                    <div class="star-rating">
                        @if($prop->reviews->count() > 0)
                            @php
                                $avgStars = round($prop->reviews->avg('stars'));
                            @endphp
                            @for ($i = 0; $i < $avgStars; $i++)
                            <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            @endfor
                            @for ($i = $avgStars; $i < 5; $i++)
                            <svg viewBox="0 0 24 24" style="fill: #E2E8F0;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            @endfor
                            <span style="font-size: 0.8rem; color: var(--text-light-slate); margin-left: 0.25rem;">({{ $prop->reviews->count() }})</span>
                        @else
                            <span style="font-size: 0.8rem; color: var(--text-light-slate); font-weight: 500; font-style: italic;">Tidak ada ulasan</span>
                        @endif
                    </div>
                    <div class="property-location">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        {{ $prop->address }}
                    </div>
                    <div class="property-footer">
                        <span class="property-price">Rp {{ number_format($prop->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Rekomendasi Rumah Murah Section -->
<section class="section bg-light" style="padding-top: 1.5rem; padding-bottom: 1rem;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
            <div class="section-header" style="margin-bottom: 0;">
                <h2>Rekomendasi Rumah Murah</h2>
            </div>
            <a href="/properti?type=rumah" style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.95rem; font-weight: 600; color: var(--primary); text-decoration: none; transition: var(--transition);" onmouseover="this.style.color='var(--secondary)'" onmouseout="this.style.color='var(--primary)'">
                <span>Lihat Semua</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>

        <div class="slider-container">
            <div class="slider-wrapper" id="slider-murah" onscroll="checkSliderScroll('slider-murah', 'btn-murah-left', 'btn-murah-right')">
                <div class="slider-track">
                    @foreach($cheapProperties as $prop)
                    <div class="property-card" style="cursor: pointer;" onclick="window.location='{{ route('properties.show_public', $prop->id) }}'">
                        <div class="property-img-wrapper">
                            <img src="{{ $prop->image }}" alt="{{ $prop->title }}" class="property-img">
                        </div>
                        <div class="property-content">
                            <h3 class="property-title">{{ $prop->title }}</h3>
                            <div class="star-rating">
                                @if($prop->reviews->count() > 0)
                                    @php
                                        $avgStars = round($prop->reviews->avg('stars'));
                                    @endphp
                                    @for ($i = 0; $i < $avgStars; $i++)
                                    <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                    @for ($i = $avgStars; $i < 5; $i++)
                                    <svg viewBox="0 0 24 24" style="fill: #E2E8F0;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                    <span style="font-size: 0.8rem; color: var(--text-light-slate); margin-left: 0.25rem;">({{ $prop->reviews->count() }})</span>
                                @else
                                    <span style="font-size: 0.8rem; color: var(--text-light-slate); font-weight: 500; font-style: italic;">Tidak ada ulasan</span>
                                @endif
                            </div>
                            <div class="property-location">
                                <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                {{ $prop->address }}
                            </div>
                            <div class="property-footer">
                                <span class="property-price">Rp {{ number_format($prop->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Left Button -->
            <button id="btn-murah-left" class="slider-btn" style="left: -22px; right: auto; opacity: 0; pointer-events: none;" onclick="scrollSlider('slider-murah', -300)">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <!-- Right Button -->
            <button id="btn-murah-right" class="slider-btn" onclick="scrollSlider('slider-murah', 300)">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
    </div>
</section>

<!-- Villa Dengan View Terbaik Section -->
<section class="section" style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
            <div class="section-header" style="margin-bottom: 0;">
                <h2>Villa Dengan View Terbaik</h2>
            </div>
            <a href="/properti?type=villa" style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.95rem; font-weight: 600; color: var(--primary); text-decoration: none; transition: var(--transition);" onmouseover="this.style.color='var(--secondary)'" onmouseout="this.style.color='var(--primary)'">
                <span>Lihat Semua</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>

        <div class="slider-container">
            <div class="slider-wrapper" id="slider-view" onscroll="checkSliderScroll('slider-view', 'btn-view-left', 'btn-view-right')">
                <div class="slider-track">
                    @foreach($bestViewVillas as $prop)
                    <div class="property-card" style="cursor: pointer;" onclick="window.location='{{ route('properties.show_public', $prop->id) }}'">
                        <div class="property-img-wrapper">
                            <img src="{{ $prop->image }}" alt="{{ $prop->title }}" class="property-img">
                        </div>
                        <div class="property-content">
                            <h3 class="property-title">{{ $prop->title }}</h3>
                            <div class="star-rating">
                                @if($prop->reviews->count() > 0)
                                    @php
                                        $avgStars = round($prop->reviews->avg('stars'));
                                    @endphp
                                    @for ($i = 0; $i < $avgStars; $i++)
                                    <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                    @for ($i = $avgStars; $i < 5; $i++)
                                    <svg viewBox="0 0 24 24" style="fill: #E2E8F0;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                    <span style="font-size: 0.8rem; color: var(--text-light-slate); margin-left: 0.25rem;">({{ $prop->reviews->count() }})</span>
                                @else
                                    <span style="font-size: 0.8rem; color: var(--text-light-slate); font-weight: 500; font-style: italic;">Tidak ada ulasan</span>
                                @endif
                            </div>
                            <div class="property-location">
                                <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                {{ $prop->address }}
                            </div>
                            <div class="property-footer">
                                <span class="property-price">Rp {{ number_format($prop->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Left Button -->
            <button id="btn-view-left" class="slider-btn" style="left: -22px; right: auto; opacity: 0; pointer-events: none;" onclick="scrollSlider('slider-view', -300)">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <!-- Right Button -->
            <button id="btn-view-right" class="slider-btn" onclick="scrollSlider('slider-view', 300)">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
    </div>
</section>

<!-- Promo Spesial Section -->
<section class="promo-section" style="padding-top: 3.5rem; padding-bottom: 3.5rem;">
    <div class="container">
        <div class="promo-header">
            <div class="promo-title-wrapper">
                <div class="promo-title-container">
                    <div class="promo-dot"></div>
                    <h2>Promo Spesial</h2>
                </div>
                <p>Dapatkan penawaran terbaik hari ini</p>
            </div>
            <a href="{{ route('promo.public') }}" class="btn-promo-all">Lihat Semua Promo</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
            <!-- Voucher 1 -->
            <div style="background: linear-gradient(135deg, var(--primary) 0%, #0c201a 100%); color: white; border-radius: var(--radius-lg); padding: 1.5rem; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; height: 180px; box-shadow: var(--shadow-md); border-left: 6px solid var(--secondary);">
                <!-- Circles overlay for ticket effect -->
                <div style="position: absolute; left: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
                <div style="position: absolute; right: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
                
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <span style="background: rgba(255,255,255,0.2); font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.5rem; border-radius: 4px; text-transform: uppercase;">Semua Properti</span>
                            <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.5rem; font-weight: 700; color: var(--secondary);">Diskon 20%</h3>
                        </div>
                        <span style="font-size: 1.75rem; opacity: 0.25;">🏷️</span>
                    </div>
                    <p style="margin: 0; font-size: 0.8rem; color: #cbd5e1; line-height: 1.3;">Gunakan untuk memesan properti apa saja di Managee. Berlaku s.d. 15 Jul 2026.</p>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed rgba(255,255,255,0.2); padding-top: 0.75rem; margin-top: 0.5rem;">
                    <code style="font-family: monospace; font-size: 1.1rem; font-weight: 700; color: white; letter-spacing: 1px;">EARLYBIRD20</code>
                    <button onclick="copyPromoCode('EARLYBIRD20', this)" style="background: white; color: var(--primary); border: none; padding: 0.35rem 0.75rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: var(--transition);">Salin Kode</button>
                </div>
            </div>

            <!-- Voucher 2 -->
            <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white; border-radius: var(--radius-lg); padding: 1.5rem; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; height: 180px; box-shadow: var(--shadow-md); border-left: 6px solid #fbbf24;">
                <!-- Circles overlay for ticket effect -->
                <div style="position: absolute; left: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
                <div style="position: absolute; right: -10px; top: calc(50% - 10px); width: 20px; height: 20px; border-radius: 50%; background: white;"></div>
                
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <span style="background: rgba(255,255,255,0.15); font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.5rem; border-radius: 4px; text-transform: uppercase; color: #fbbf24;">Khusus Villa Canggu</span>
                            <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.5rem; font-weight: 700; color: #fbbf24;">Diskon 10%</h3>
                        </div>
                        <span style="font-size: 1.75rem; opacity: 0.25;">🌴</span>
                    </div>
                    <p style="margin: 0; font-size: 0.8rem; color: #94a3b8; line-height: 1.3;">Nikmati akhir pekan seru di Villa Canggu. Berlaku s.d. 30 Jun 2026.</p>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed rgba(255,255,255,0.15); padding-top: 0.75rem; margin-top: 0.5rem;">
                    <code style="font-family: monospace; font-size: 1.1rem; font-weight: 700; color: white; letter-spacing: 1px;">WEEKENDSERU</code>
                    <button onclick="copyPromoCode('WEEKENDSERU', this)" style="background: #fbbf24; color: #0f172a; border: none; padding: 0.35rem 0.75rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: var(--transition);">Salin Kode</button>
                </div>
            </div>
        </div>

        <script>
            function copyPromoCode(code, button) {
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

            function scrollSlider(id, amount) {
                document.getElementById(id).scrollBy({left: amount, behavior: 'smooth'});
            }

            function checkSliderScroll(sliderId, leftBtnId, rightBtnId) {
                const slider = document.getElementById(sliderId);
                const leftBtn = document.getElementById(leftBtnId);
                const rightBtn = document.getElementById(rightBtnId);
                
                if (!slider || !leftBtn || !rightBtn) return;
                
                // Toggle left button
                if (slider.scrollLeft <= 5) {
                    leftBtn.style.opacity = '0';
                    leftBtn.style.pointerEvents = 'none';
                } else {
                    leftBtn.style.opacity = '1';
                    leftBtn.style.pointerEvents = 'auto';
                }
                
                // Toggle right button
                if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5) {
                    rightBtn.style.opacity = '0';
                    rightBtn.style.pointerEvents = 'none';
                } else {
                    rightBtn.style.opacity = '1';
                    rightBtn.style.pointerEvents = 'auto';
                }
            }

             // Initial check on load
            document.addEventListener('DOMContentLoaded', () => {
                // Set initial transition styles
                const btns = document.querySelectorAll('.slider-btn');
                btns.forEach(btn => {
                    btn.style.transition = 'opacity 0.3s ease, transform 0.2s ease, background-color 0.2s';
                });



                checkSliderScroll('slider-murah', 'btn-murah-left', 'btn-murah-right');
                checkSliderScroll('slider-view', 'btn-view-left', 'btn-view-right');
                
                // Double check after layout paints (images load)
                setTimeout(() => {
                    checkSliderScroll('slider-murah', 'btn-murah-left', 'btn-murah-right');
                    checkSliderScroll('slider-view', 'btn-view-left', 'btn-view-right');
                }, 500);
            });
        </script>
    </div>
</section>

@endsection
