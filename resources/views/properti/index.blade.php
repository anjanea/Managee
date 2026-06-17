@extends('layouts.app')

@section('title', 'Managee - Temukan Properti Terbaik')

@section('content')

<!-- Breadcrumb -->
<div class="container" style="margin-top: 110px; margin-bottom: 15px;">
    <div class="breadcrumb">
        <a href="/">Beranda</a>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 0.5rem; color: var(--text-muted); opacity: 0.7;"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>Properti</span>
    </div>
</div>

<!-- Banner / Search Section -->
<section class="properti-hero" style="margin-bottom: 3rem; text-align: center;">
    <div class="container">
        <div class="properti-hero-banner" style="margin-bottom: 2rem;">
            <h1 style="color: white; margin-bottom: 2rem;">Temukan Properti Terbaik Sesuai Kebutuhan Anda</h1>
        </div>

        <form action="{{ route('properties.index') }}" method="GET" style="background: white; padding: 0.4rem 0.5rem 0.4rem 1.5rem; border-radius: var(--radius-full); box-shadow: var(--shadow-lg); max-width: 1050px; margin: 0 auto; display: flex; align-items: center; gap: 0.75rem; text-align: left; height: 58px;">
            <!-- Lokasi -->
            <div style="flex: 2; display: flex; flex-direction: column; justify-content: center; position: relative;">
                <label style="font-size: 0.65rem; font-weight: 700; color: var(--text-main); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.1rem;">
                    {{ request('search') ? 'Cari: "' . request('search') . '"' : 'Pencarian' }}
                </label>
                <div style="position: relative; display: flex; align-items: center; width: 100%;">
                    <input type="text" name="search" id="search-input-properti" value="{{ request('search') }}" placeholder="Cari properti..." style="border: none; outline: none; font-size: 0.85rem; color: var(--text-main); background: transparent; font-family: inherit; width: 100%; padding-right: 1.25rem;">
                    <span id="clear-lokasi-properti" style="position: absolute; right: 0; cursor: pointer; color: var(--text-muted); font-weight: bold; font-size: 1.1rem; display: {{ request('search') ? 'inline-block' : 'none' }}; line-height: 1;" onclick="clearPropertiSearch()">×</span>
                </div>
            </div>
            
            <div style="width: 1px; height: 32px; background-color: var(--border); flex-shrink: 0;"></div>

            <!-- Tipe Properti -->
            <div style="flex: 1.2; display: flex; flex-direction: column; justify-content: center;">
                <label style="font-size: 0.65rem; font-weight: 700; color: var(--text-main); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.1rem;">
                    {{ request('type') && request('type') !== 'all' ? 'Tipe: ' . ucfirst(request('type')) : 'Tipe Hunian' }}
                </label>
                <select name="type" style="border: none; outline: none; font-size: 0.85rem; color: var(--text-main); background: transparent; cursor: pointer; font-family: inherit; width: 100%;">
                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                    <option value="apartemen" {{ request('type') == 'apartemen' ? 'selected' : '' }}>Apartemen</option>
                    <option value="rumah" {{ request('type') == 'rumah' ? 'selected' : '' }}>Rumah</option>
                    <option value="villa" {{ request('type') == 'villa' ? 'selected' : '' }}>Villa</option>
                </select>
            </div>

            <div style="width: 1px; height: 32px; background-color: var(--border); flex-shrink: 0;"></div>

            <!-- Min Price -->
            <div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                <label style="font-size: 0.65rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.1rem;">Min Harga</label>
                <input type="number" name="min_price" value="{{ request('min_price', '2000000') }}" placeholder="Rp 0" style="border: none; outline: none; font-size: 0.85rem; color: var(--text-main); background: transparent; font-family: inherit; width: 100%;">
            </div>

            <span style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-top: 0.5rem; flex-shrink: 0;">s.d.</span>

            <!-- Max Price -->
            <div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                <label style="font-size: 0.65rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.1rem;">Max Harga</label>
                <input type="number" name="max_price" value="{{ request('max_price', '25000000') }}" placeholder="Rp Tanpa Batas" style="border: none; outline: none; font-size: 0.85rem; color: var(--text-main); background: transparent; font-family: inherit; width: 100%;">
            </div>

            <div style="width: 1px; height: 32px; background-color: var(--border); flex-shrink: 0;"></div>

            <!-- Rating Min -->
            <div style="flex: 1.1; display: flex; flex-direction: column; justify-content: center;">
                <label style="font-size: 0.65rem; font-weight: 700; color: var(--text-main); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.1rem;">
                    Rating
                </label>
                <select name="rating" style="border: none; outline: none; font-size: 0.85rem; color: var(--text-main); background: transparent; cursor: pointer; font-family: inherit; width: 100%;">
                    <option value="all" {{ request('rating') == 'all' ? 'selected' : '' }}>Semua Rating</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Bintang</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Bintang</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Bintang</option>
                </select>
            </div>

            <div style="width: 1px; height: 32px; background-color: var(--border); flex-shrink: 0;"></div>

            <!-- Sorting -->
            <div style="flex: 1.2; display: flex; flex-direction: column; justify-content: center;">
                <label style="font-size: 0.65rem; font-weight: 700; color: var(--text-main); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.1rem;">
                    @if(request('sort') === 'price_asc')
                        Urutan: Termurah
                    @elseif(request('sort') === 'price_desc')
                        Urutan: Termahal
                    @elseif(request('sort') === 'stars_desc')
                        Urutan: Terpopuler
                    @else
                        Urutan
                    @endif
                </label>
                <select name="sort" style="border: none; outline: none; font-size: 0.85rem; color: var(--text-main); background: transparent; cursor: pointer; font-family: inherit; width: 100%;">
                    <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                    <option value="stars_desc" {{ request('sort') == 'stars_desc' ? 'selected' : '' }}>Ulasan: Terpopuler</option>
                </select>
            </div>

            <!-- Actions -->
            <div style="display: flex; align-items: center; gap: 0.35rem; flex-shrink: 0; padding-right: 0.25rem;">
                <a href="{{ route('properties.index') }}" style="color: var(--text-muted); font-size: 0.8rem; font-weight: 600; text-decoration: none; padding: 0.5rem 0.75rem; border-radius: var(--radius-full); transition: var(--transition);" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">Reset</a>
                <button type="submit" class="search-btn" style="width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background-color: var(--secondary); color: white; border: none; cursor: pointer; transition: var(--transition);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </div>
        </form>

        <script>
        function clearPropertiSearch() {
            const input = document.getElementById('search-input-properti');
            const btn = document.getElementById('clear-lokasi-properti');
            if (input) {
                input.value = '';
                input.focus();
            }
            if (btn) {
                btn.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('search-input-properti');
            const btn = document.getElementById('clear-lokasi-properti');
            if (input && btn) {
                input.addEventListener('input', () => {
                    btn.style.display = input.value.trim() !== '' ? 'inline-block' : 'none';
                });
            }
        });
        </script>
    </div>
</section>

<!-- Listings Grid -->
<section class="section" style="padding-top: 0; padding-bottom: 5rem;">
    <div class="container">
        @if($properties->count() > 0)
            <div class="property-grid" style="margin-bottom: 4rem;">
                @foreach($properties as $property)
                    <div class="property-card" style="cursor: pointer;" onclick="window.location='{{ route('properties.show_public', $property->id) }}'">
                        <div class="property-img-wrapper">
                            <img src="{{ $property->image }}" alt="{{ $property->title }}" class="property-img">
                        </div>
                        <div class="property-content">
                            <h3 class="property-title">{{ $property->title }}</h3>
                            <div class="star-rating">
                                @if($property->reviews->count() > 0)
                                    @php
                                        $avgStars = round($property->reviews->avg('stars'));
                                    @endphp
                                    @for ($i = 0; $i < $avgStars; $i++)
                                        <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                    @for ($i = $avgStars; $i < 5; $i++)
                                        <svg viewBox="0 0 24 24" style="fill: #E2E8F0;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                    <span style="font-size: 0.8rem; color: var(--text-light-slate); margin-left: 0.25rem;">({{ $property->reviews->count() }})</span>
                                @else
                                    <span style="font-size: 0.8rem; color: var(--text-light-slate); font-weight: 500; font-style: italic;">Tidak ada ulasan</span>
                                @endif
                            </div>
                            <div class="property-location">
                                <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                {{ $property->address }}
                            </div>
                            <div class="property-footer">
                                <span class="property-price">Rp {{ number_format($property->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Custom Pagination -->
            <div class="custom-pagination">
                {{-- Previous Page Link --}}
                @if ($properties->onFirstPage())
                    <span class="pagination-btn disabled">Sebelumnya</span>
                @else
                    <a href="{{ $properties->previousPageUrl() }}" class="pagination-btn">Sebelumnya</a>
                @endif

                {{-- Pagination Pages --}}
                @foreach ($properties->getUrlRange(1, $properties->lastPage()) as $page => $url)
                    @if ($page == $properties->currentPage())
                        <span class="pagination-number active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($properties->hasMorePages())
                    <a href="{{ $properties->nextPageUrl() }}" class="pagination-btn">Berikutnya</a>
                @else
                    <span class="pagination-btn disabled">Berikutnya</span>
                @endif
            </div>
        @else
            <div style="text-align: center; padding: 5rem 0; color: var(--text-muted);">
                <svg viewBox="0 0 24 24" width="64" height="64" stroke="currentColor" stroke-width="1.5" fill="none" style="margin-bottom: 1.5rem; opacity: 0.5; display: inline-block;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                <h3 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem;">Tidak ada properti ditemukan</h3>
                <p>Coba cari dengan kata kunci lain atau ubah kategori filter Anda.</p>
                <a href="{{ route('properties.index') }}" class="btn btn-primary" style="margin-top: 1.5rem;">Reset Filter</a>
            </div>
        @endif
    </div>
</section>

@endsection
