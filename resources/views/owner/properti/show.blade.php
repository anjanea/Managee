@extends('layouts.owner')

@section('title', 'Managee Owner - Rincian Properti: ' . $property->title)
@section('page_title', 'Detail Properti')

@section('content')
@php
    $ownerGallery = is_array($property->images) ? $property->images : [];
    if (empty($ownerGallery) && $property->image) {
        $ownerGallery[] = $property->image;
    }
@endphp

<div style="max-width: 1100px; margin: 0 auto;">
    <!-- Back Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <a href="{{ route('owner.properties.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-muted); font-weight: 500; font-size: 0.95rem; transition: var(--transition);">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Kembali ke Daftar Properti</span>
        </a>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('owner.properties.edit', $property->id) }}" class="btn btn-outline" style="text-decoration: none; padding: 0.5rem 1.25rem; font-size: 0.9rem;">Ubah Rincian</a>
        </div>
    </div>

    <!-- Details Columns -->
    <div style="display: flex; gap: 2rem; align-items: flex-start; flex-wrap: wrap;">
        <!-- Left: Gallery & Description -->
        <div style="flex: 2; min-width: 320px; display: flex; flex-direction: column; gap: 2rem;">
            <!-- Main Photo & Gallery -->
            <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow-sm);">
                <div style="width: 100%; height: 350px; border-radius: var(--radius-md); overflow: hidden; margin-bottom: 1rem; border: 1px solid var(--border);">
                    <img id="main-gallery-view" src="{{ $property->image }}" alt="{{ $property->title }}" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="openOwnerMainLightbox()">
                </div>
                
                @if(count($ownerGallery) > 0)
                    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 1rem;">
                        @foreach($ownerGallery as $index => $imgUrl)
                            <div class="gallery-thumbnail" style="width: 80px; height: 60px; border-radius: var(--radius-md); overflow: hidden; cursor: pointer; border: 2px solid {{ $imgUrl == $property->image ? 'var(--primary)' : 'var(--border)' }}; transition: var(--transition);" onclick="switchMainImage(this, '{{ $imgUrl }}'); openLightbox({{ json_encode($ownerGallery) }}, {{ $index }});">
                                <img src="{{ $imgUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Description -->
            <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow-sm);">
                <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--primary); margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Deskripsi Properti</h4>
                <p style="font-size: 0.95rem; color: var(--text-main); line-height: 1.6; white-space: pre-line;">
                    {{ $property->description ?: 'Tidak ada deskripsi rincian yang ditambahkan untuk unit properti ini.' }}
                </p>
            </div>

            <!-- Reviews -->
            <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; gap: 1rem;">
                <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Ulasan Properti</h4>
                
                @forelse($reviews as $rev)
                    <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem; margin-bottom: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background-color: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem;">
                                    {{ strtoupper(substr($rev->user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight: 600; font-size: 0.95rem; color: var(--text-main);">{{ $rev->user->name }}</span>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: flex-end;">
                                <div style="color: #fbbf24; font-size: 0.9rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $rev->stars ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $rev->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--text-main); line-height: 1.4; font-style: italic;">
                            "{{ $rev->comment }}"
                        </p>
                    </div>
                @empty
                    <p style="font-size: 0.9rem; color: var(--text-muted); font-style: italic; margin: 0;">Belum ada ulasan dari penyewa untuk properti ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Right: Core Specs & Amenities -->
        <div style="flex: 1.2; min-width: 320px; display: flex; flex-direction: column; gap: 2rem; width: 100%;">
            <!-- Summary Box -->
            <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow-sm);">
                <span style="font-size: 0.8rem; font-weight: 700; color: white; background-color: var(--secondary); padding: 0.2rem 0.6rem; border-radius: var(--radius-md); text-transform: uppercase;">{{ $property->type }}</span>
                <h2 style="font-size: 1.6rem; font-weight: 700; color: var(--primary); margin-top: 0.75rem; margin-bottom: 0.5rem;">{{ $property->title }}</h2>
                
                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <span>{{ $property->address }}, {{ $property->location }}</span>
                </div>

                <div style="border-top: 1px solid var(--border); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 500;">Harga Sewa Per Malam:</span>
                    <span style="font-size: 1.4rem; font-weight: 700; color: var(--primary);">Rp {{ number_format($property->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Specs Grid Box -->
            <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow-sm);">
                <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--primary); margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Spesifikasi Detail</h4>
                
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">Kamar Tidur:</span>
                        <span style="font-weight: 600;">{{ $property->bedrooms ?: '-' }} Kamar</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">Kamar Mandi:</span>
                        <span style="font-weight: 600;">{{ $property->bathrooms ?: '-' }} Ruang</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">Luas Properti:</span>
                        <span style="font-weight: 600;">{{ $property->area }} m²</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">Jumlah Lantai:</span>
                        <span style="font-weight: 600;">{{ $property->floors ?: '-' }} Lantai</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">Kapasitas Garasi:</span>
                        <span style="font-weight: 600;">{{ $property->garage ?: '-' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">Tahun Pembangunan:</span>
                        <span style="font-weight: 600;">{{ $property->year_built ?: '-' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">Status Sertifikat:</span>
                        <span style="font-weight: 600;">{{ $property->certificate ?: '-' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; border-bottom: 1px dashed var(--border); padding-bottom: 0.4rem;">
                        <span style="color: var(--text-muted);">Daya Listrik:</span>
                        <span style="font-weight: 600;">{{ $property->electricity ? $property->electricity . ' Watt' : '-' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; padding-bottom: 0.2rem;">
                        <span style="color: var(--text-muted);">Penyediaan Air:</span>
                        <span style="font-weight: 600;">{{ $property->water_source ?: '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Facilities Box -->
            <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow-sm);">
                <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--primary); margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Fasilitas Tersedia</h4>
                
                @if(is_array($property->facilities) && count($property->facilities) > 0)
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                        @foreach($property->facilities as $fac)
                            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: var(--text-main);">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>{{ $fac }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="font-size: 0.9rem; color: var(--text-muted);">Tidak ada fasilitas spesifik yang didaftarkan.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function switchMainImage(thumbnailEl, url) {
    document.getElementById('main-gallery-view').src = url;
    
    // Reset borders of all thumbnails
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    thumbnails.forEach(el => {
        el.style.borderColor = 'var(--border)';
    });
    
    // Outline selected thumbnail
    thumbnailEl.style.borderColor = 'var(--primary)';
}
</script>

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

function openOwnerMainLightbox() {
    const mainSrc = document.getElementById('main-gallery-view').src;
    const gallery = {!! json_encode($ownerGallery) !!};
    let index = gallery.indexOf(mainSrc);
    if (index === -1) index = 0;
    openLightbox(gallery, index);
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
