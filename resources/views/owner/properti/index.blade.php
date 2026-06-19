@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Daftar Properti Saya')
@section('page_title', 'Properti Saya')

@section('content')

<style>
@keyframes modalFadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.btn-action-detail {
    border: 1px solid var(--primary) !important;
    color: var(--primary) !important;
    background: transparent !important;
}
.btn-action-detail:hover {
    background: var(--primary) !important;
    color: #ffffff !important;
}
.btn-action-edit {
    border: 1px solid var(--border) !important;
    color: var(--text-main) !important;
    background: transparent !important;
}
.btn-action-edit:hover {
    background: var(--primary) !important;
    border-color: var(--primary) !important;
    color: #ffffff !important;
}
.btn-action-delete {
    border: 1px solid #fecaca !important;
    color: #ef4444 !important;
    background: transparent !important;
}
.btn-action-delete:hover {
    background: #ef4444 !important;
    border-color: #ef4444 !important;
    color: #ffffff !important;
}
</style>

@if(session('success'))
    <div class="owner-alert owner-alert-success" style="margin-bottom: 2rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="owner-card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 1rem;">
        <h4 style="margin: 0; color: var(--primary);">Semua Unit Properti Anda</h4>
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <a href="{{ route('owner.promo.index') }}" class="btn" style="background-color: transparent; border: 1px solid var(--border); color: var(--text-main); font-weight: 600; font-size: 0.95rem; text-decoration: none; padding: 0.6rem 1.25rem; border-radius: var(--radius-md); display: inline-flex; align-items: center; gap: 0.5rem; transition: var(--transition);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                <span>Kelola Promo</span>
            </a>
            <a href="{{ route('owner.properties.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; padding: 0.6rem 1.25rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Tambah Properti</span>
            </a>
        </div>
    </div>
    
    <div class="card-body" style="padding: 1.5rem;">
        <div style="margin-bottom: 1.25rem; display: flex; max-width: 320px; align-items: center; gap: 0.5rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2" style="flex-shrink: 0;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" id="search-properti" placeholder="Cari berdasarkan nama, tipe, atau lokasi..." style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 0.9rem; outline: none; transition: var(--transition);">
        </div>

        <div class="table-responsive">
            <table class="owner-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Judul Unit</th>
                        <th>Tipe</th>
                        <th>Harga / Bulan</th>
                        <th>Lokasi</th>
                        <th>Bintang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($properties as $property)
                        <tr>
                            <td>
                                <img src="{{ $property->image }}" alt="{{ $property->title }}" style="width: 64px; height: 48px; object-fit: cover; border-radius: var(--radius-md);">
                            </td>
                            <td style="font-weight: 600; color: var(--text-main);">
                                <div>{{ $property->title }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 400; margin-top: 0.25rem;">
                                    {{ $property->bedrooms ?: '-' }} KT • {{ $property->bathrooms ?: '-' }} KM • {{ $property->area ?: '0' }}m²
                                </div>
                            </td>
                            <td style="text-transform: capitalize;">{{ $property->type }}</td>
                            <td style="font-weight: 600;">Rp {{ number_format($property->price, 0, ',', '.') }}</td>
                            <td>{{ $property->location }}</td>
                            <td>
                                @php
                                    $reviewsCount = $property->reviews->count();
                                    $avgStars = $reviewsCount > 0 ? round($property->reviews->avg('stars')) : 0;
                                @endphp
                                @if($reviewsCount > 0)
                                    <div style="color: #fbbf24; font-size: 0.95rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                            {{ $i <= $avgStars ? '★' : '☆' }}
                                        @endfor
                                        <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: normal;">({{ $reviewsCount }})</span>
                                    </div>
                                @else
                                    <span style="font-size: 0.85rem; color: var(--text-muted); font-style: italic;">Belum ada ulasan</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <a href="{{ route('owner.properties.show', $property->id) }}" class="btn btn-action-detail" style="padding: 0.35rem 0.75rem; font-size: 0.85rem; text-decoration: none;">Detail</a>
                                    <a href="{{ route('owner.properties.edit', $property->id) }}" class="btn btn-action-edit" style="padding: 0.35rem 0.75rem; font-size: 0.85rem; text-decoration: none;">Ubah</a>
                                    <button type="button" onclick="confirmDeleteProperty('{{ $property->id }}', '{{ addslashes($property->title) }}')" class="btn btn-action-delete" style="padding: 0.35rem 0.75rem; font-size: 0.85rem; cursor: pointer;">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 3rem 0; color: var(--text-muted);">
                                Anda belum memiliki properti terdaftar. Silakan tambah unit baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div id="properti-count-info" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">
                Menampilkan {{ $properties->firstItem() ?: 0 }} - {{ $properties->lastItem() ?: 0 }} dari {{ $properties->total() }} properti
            </div>
            <div class="custom-pagination" style="margin-top: 0; justify-content: flex-end;">
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
        </div>
    </div>
</div>

<div id="delete-property-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: #FFFFFF; border-radius: 16px; padding: 2rem; max-width: 450px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); text-align: center; border: 1px solid var(--border); animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        <!-- Warning Icon -->
        <div style="background: #FEE2E2; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem auto; color: #EF4444;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; font-family: 'Outfit', sans-serif;">Konfirmasi Hapus Properti</h3>
        <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1.75rem;">
            Apakah Anda yakin ingin menghapus properti <strong id="delete-property-title-modal" style="color: var(--text-main);"></strong>? Data sewa dan ulasan terkait properti ini juga akan terpengaruh. Tindakan ini tidak dapat dibatalkan.
        </p>
        <div style="display: flex; gap: 0.75rem; justify-content: center;">
            <button type="button" onclick="closeDeleteModal()" class="btn" style="background: #f1f5f9; color: var(--text-main); border: 1px solid var(--border); padding: 0.6rem 1.5rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; font-size: 0.9rem;">Batal</button>
            <form id="delete-property-form" action="" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background: #ef4444; color: white; border: none; padding: 0.6rem 1.5rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; font-size: 0.9rem;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
let deleteFormActionUrl = '';

function confirmDeleteProperty(id, title) {
    const form = document.getElementById('delete-property-form');
    form.action = `/owner/properties/${id}`;
    document.getElementById('delete-property-title-modal').textContent = title;
    document.getElementById('delete-property-modal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('delete-property-modal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-properti');
    const tableRows = document.querySelectorAll('.owner-table tbody tr');

    if (searchInput) {
        // Focus state effect
        searchInput.addEventListener('focus', function() {
            searchInput.style.borderColor = 'var(--primary)';
        });
        searchInput.addEventListener('blur', function() {
            searchInput.style.borderColor = 'var(--border)';
        });

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;
            let totalCount = 0;
            
            tableRows.forEach(row => {
                // If it is the empty state row, skip it
                if (row.cells.length === 1 && row.cells[0].getAttribute('colspan')) return;
                totalCount++;

                const titleText = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
                const typeText = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
                const locationText = row.cells[4] ? row.cells[4].textContent.toLowerCase() : '';

                if (titleText.includes(query) || typeText.includes(query) || locationText.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const countInfo = document.getElementById('properti-count-info');
            if (query !== '') {
                countInfo.textContent = `Menampilkan ${visibleCount} dari ${totalCount} properti (hasil pencarian)`;
            } else {
                countInfo.innerHTML = `Menampilkan {{ $properties->firstItem() ?: 0 }} - {{ $properties->lastItem() ?: 0 }} dari {{ $properties->total() }} properti`;
            }
        });
    }
});
</script>

@endsection
