@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Daftar Properti Saya')
@section('page_title', 'Properti Saya')

@section('content')

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
                                    <a href="{{ route('owner.properties.show', $property->id) }}" class="btn btn-outline" style="padding: 0.35rem 0.75rem; font-size: 0.85rem; text-decoration: none; border-color: var(--primary); color: var(--primary);">Detail</a>
                                    <a href="{{ route('owner.properties.edit', $property->id) }}" class="btn btn-outline" style="padding: 0.35rem 0.75rem; font-size: 0.85rem; text-decoration: none;">Ubah</a>
                                    <form action="{{ route('owner.properties.destroy', $property->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus properti ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline" style="padding: 0.35rem 0.75rem; font-size: 0.85rem; color: #ef4444; border-color: #fecaca;">Hapus</button>
                                    </form>
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

<script>
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
