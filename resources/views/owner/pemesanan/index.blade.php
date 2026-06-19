@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Kelola Pemesanan')
@section('page_title', 'Kelola Pemesanan')

@section('content')

<!-- Back to Dashboard Link -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('owner.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; font-size: 0.9rem; font-weight: 600; color: var(--text-muted); transition: var(--transition);" onmouseover="this.style.color='var(--secondary)'" onmouseout="this.style.color='var(--text-muted)'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        <span>Kembali ke Beranda</span>
    </a>
</div>

<!-- Booking Success/Danger Alerts -->
<div id="booking-alert-container">
    @if(session('success'))
        <div class="owner-alert owner-alert-success" style="margin-bottom: 1.5rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
</div>

<!-- Search & Status Filter Bar -->
<div class="owner-search-filter-section" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 2rem; box-shadow: var(--shadow-sm); display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap;">
    <div style="display: flex; gap: 1rem; flex: 1; flex-wrap: wrap; min-width: 280px;">
        <!-- Property Selector -->
        <div style="display: flex; flex-direction: column; gap: 0.35rem; min-width: 200px; flex: 1;">
            <label for="booking-property-filter" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main);">Cari Properti</label>
            <select id="booking-property-filter" onchange="filterBookings()" style="padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.95rem; outline: none; background: var(--bg-light); cursor: pointer; transition: var(--transition);">
                <option value="all">Semua Properti</option>
                <option value="Apartemen Chilitown">Apartemen Chilitown</option>
                <option value="Villa Canggu">Villa Canggu</option>
                <option value="Rumah Modern Ubud">Rumah Modern Ubud</option>
            </select>
        </div>
        <!-- Status Selector -->
        <div style="display: flex; flex-direction: column; gap: 0.35rem; min-width: 150px;">
            <label for="booking-status-filter" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main);">Status</label>
            <select id="booking-status-filter" onchange="filterBookings()" style="padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.95rem; outline: none; background: var(--bg-light); cursor: pointer; transition: var(--transition);">
                <option value="all">Semua Status</option>
                <option value="Menunggu">Menunggu Persetujuan</option>
                <option value="Dikonfirmasi">Dikonfirmasi</option>
                <option value="Selesai">Selesai</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
    </div>
</div>

<!-- Booking Table Card -->
<div class="owner-card" style="width: 100%; margin-bottom: 2rem;">
    <div class="card-header" style="padding: 1.25rem 1.5rem;">
        <h4 style="margin: 0; color: var(--primary);">Daftar Seluruh Pemesanan</h4>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <div id="bookings-count-info" style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem; font-weight: 500;">
            Menampilkan {{ count($bookings) }} dari {{ count($bookings) }} pemesanan
        </div>
        <div class="table-responsive">
            <table class="owner-table">
                <thead>
                    <tr>
                        <th>Penyewa</th>
                        <th>Kontak</th>
                        <th>Properti</th>
                        <th>Tanggal Sewa</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="bookings-tbody">
                    @foreach($bookings as $booking)
                        <tr class="booking-row" data-property="{{ $booking->property->title }}" data-status="{{ $booking->status }}">
                            <td style="font-weight: 600; color: var(--text-main);">{{ $booking->user->name }}</td>
                            <td>
                                <div style="font-size: 0.85rem; color: var(--text-muted); display: flex; flex-direction: column; gap: 0.1rem;">
                                    <span>{{ $booking->user->email }}</span>
                                    <span>{{ $booking->user->phone ?: '-' }}</span>
                                </div>
                            </td>
                            <td>{{ $booking->property->title }}</td>
                            <td>{{ $booking->checkin_date->translatedFormat('d M') }} - {{ $booking->checkout_date->translatedFormat('d M Y') }}</td>
                            <td style="font-weight: 600; color: var(--primary);">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($booking->status == 'Selesai')
                                    <span class="badge badge-success" style="background-color: rgba(34, 197, 94, 0.1); color: #166534;">Selesai</span>
                                @elseif($booking->status == 'Dikonfirmasi')
                                    <span class="badge badge-info" style="background-color: rgba(14, 165, 233, 0.1); color: #0369a1;">Dikonfirmasi</span>
                                @elseif($booking->status == 'Menunggu')
                                    <span id="status-{{ $booking->id }}" class="badge badge-warning" style="background-color: rgba(202, 138, 4, 0.1); color: #854d0e;">Menunggu</span>
                                @else
                                    <span class="badge" style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">{{ $booking->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->status == 'Menunggu')
                                    <div id="actions-{{ $booking->id }}" style="display: flex; gap: 0.4rem; align-items: center;">
                                        <button type="button" onclick="approveBooking('{{ $booking->id }}', '{{ $booking->property->title }}')" style="background-color: #22c55e; color: white; border: none; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.2rem; transition: var(--transition);"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Terima</button>
                                        <button type="button" onclick="rejectBooking('{{ $booking->id }}', '{{ $booking->property->title }}')" style="background-color: #ef4444; color: white; border: none; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.2rem; transition: var(--transition);"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Tolak</button>
                                        
                                        <form id="approve-form-{{ $booking->id }}" action="{{ route('owner.bookings.approve', $booking->id) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <form id="reject-form-{{ $booking->id }}" action="{{ route('owner.bookings.reject', $booking->id) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function filterBookings() {
        const propFilter = document.getElementById('booking-property-filter').value;
        const statusFilter = document.getElementById('booking-status-filter').value;
        
        const rows = document.querySelectorAll('.booking-row');
        let visibleCount = 0;
        const totalCount = rows.length;
        
        rows.forEach(row => {
            const prop = row.getAttribute('data-property');
            const status = row.getAttribute('data-status');
            
            const matchProp = (propFilter === 'all' || prop === propFilter);
            const matchStatus = (statusFilter === 'all' || status === statusFilter);
            
            if (matchProp && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('bookings-count-info').textContent = `Menampilkan ${visibleCount} dari ${totalCount} pemesanan`;
    }

    document.addEventListener('DOMContentLoaded', filterBookings);

    function approveBooking(id, propertyTitle) {
        document.getElementById('approve-form-' + id).submit();
    }

    function rejectBooking(id, propertyTitle) {
        document.getElementById('reject-form-' + id).submit();
    }

    function showAlert(message, type) {
        const container = document.getElementById('booking-alert-container');
        const alertDiv = document.createElement('div');
        alertDiv.className = `owner-alert owner-alert-${type}`;
        alertDiv.style.marginBottom = '1.5rem';
        alertDiv.style.transition = 'all 0.3s ease';
        
        alertDiv.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg>
            <span>${message}</span>
        `;
        
        container.innerHTML = '';
        container.appendChild(alertDiv);
    }
</script>

@endsection
