@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Ringkasan')
@section('page_title', 'Dashboard')

@section('page_subtitle')
    <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; display: block; margin-top: 0.15rem;">Selamat datang kembali, {{ auth()->user()->name }}!</span>
@endsection

@section('content')

<!-- Welcome Banner Alert Container -->
<div id="dashboard-alert-container"></div>

<!-- Stats Grid -->
<div class="owner-stats-grid" style="margin-top: 0.5rem;">
    <div class="stat-card">
        <div class="stat-icon-wrapper" style="background: rgba(26, 60, 52, 0.1); color: var(--primary);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Properti</span>
            <span class="stat-value">{{ $stats['properties_count'] }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrapper" style="background: rgba(202, 138, 4, 0.1); color: var(--secondary);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Pemesanan Aktif</span>
            <span class="stat-value">{{ $stats['bookings_count'] }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrapper" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Artikel Blog</span>
            <span class="stat-value">{{ $stats['articles_count'] }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrapper" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Kunjungan Iklan</span>
            <span class="stat-value">{{ number_format($stats['views_count'], 0, ',', '.') }}</span>
        </div>
    </div>
</div>

<!-- Performance Chart Panel -->
<div class="owner-card" style="margin-bottom: 2rem;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem;">
        <div>
            <h4 style="margin: 0; color: var(--primary);">Analisis Kunjungan & Performa Iklan</h4>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <span style="font-size: 0.8rem; font-weight: 600; padding: 0.25rem 0.75rem; background: var(--primary); color: white; border-radius: var(--radius-md);">7 Hari Terakhir</span>
        </div>
    </div>
    <div class="card-body" style="padding: 1.5rem 2rem;">
        <div style="width: 100%; height: 200px; position: relative;">
            <svg viewBox="0 0 100 25" style="width: 100%; height: 180px; overflow: visible;">
                <!-- Grids -->
                <line x1="0" y1="0" x2="100" y2="0" stroke="#f1f5f9" stroke-width="0.3" />
                <line x1="0" y1="5" x2="100" y2="5" stroke="#f1f5f9" stroke-width="0.3" />
                <line x1="0" y1="10" x2="100" y2="10" stroke="#f1f5f9" stroke-width="0.3" />
                <line x1="0" y1="15" x2="100" y2="15" stroke="#f1f5f9" stroke-width="0.3" />
                <line x1="0" y1="20" x2="100" y2="20" stroke="#e2e8f0" stroke-width="0.5" />
                
                <!-- Line path (Formal straight lines) -->
                <path d="M 0 16 L 16.6 12 L 33.3 15 L 50 8 L 66.6 11 L 83.3 4 L 100 7" fill="none" stroke="var(--primary)" stroke-width="0.8" stroke-linecap="round" />
                <!-- Shading -->
                <path d="M 0 16 L 16.6 12 L 33.3 15 L 50 8 L 66.6 11 L 83.3 4 L 100 7 L 100 20 L 0 20 Z" fill="rgba(26, 60, 52, 0.05)" />
                
                <!-- Dots -->
                <circle cx="0" cy="16" r="0.8" fill="var(--primary)" stroke="white" stroke-width="0.2" />
                <circle cx="16.6" cy="12" r="0.8" fill="var(--primary)" stroke="white" stroke-width="0.2" />
                <circle cx="33.3" cy="15" r="0.8" fill="var(--primary)" stroke="white" stroke-width="0.2" />
                <circle cx="50" cy="8" r="0.8" fill="var(--primary)" stroke="white" stroke-width="0.2" />
                <circle cx="66.6" cy="11" r="0.8" fill="var(--primary)" stroke="white" stroke-width="0.2" />
                <circle cx="83.3" cy="4" r="0.8" fill="var(--primary)" stroke="white" stroke-width="0.2" />
                <circle cx="100" cy="7" r="0.8" fill="var(--primary)" stroke="white" stroke-width="0.2" />

                <!-- X Axis Text Labels perfectly aligned inside the SVG grid system -->
                <text x="0" y="24" font-size="2.2" font-weight="600" fill="#64748b" text-anchor="middle" font-family="'Outfit', sans-serif">Senin</text>
                <text x="16.6" y="24" font-size="2.2" font-weight="600" fill="#64748b" text-anchor="middle" font-family="'Outfit', sans-serif">Selasa</text>
                <text x="33.3" y="24" font-size="2.2" font-weight="600" fill="#64748b" text-anchor="middle" font-family="'Outfit', sans-serif">Rabu</text>
                <text x="50" y="24" font-size="2.2" font-weight="600" fill="#64748b" text-anchor="middle" font-family="'Outfit', sans-serif">Kamis</text>
                <text x="66.6" y="24" font-size="2.2" font-weight="600" fill="#64748b" text-anchor="middle" font-family="'Outfit', sans-serif">Jumat</text>
                <text x="83.3" y="24" font-size="2.2" font-weight="600" fill="#64748b" text-anchor="middle" font-family="'Outfit', sans-serif">Sabtu</text>
                <text x="100" y="24" font-size="2.2" font-weight="600" fill="#64748b" text-anchor="middle" font-family="'Outfit', sans-serif">Minggu</text>
            </svg>
        </div>
    </div>
</div>

<!-- Grid Layout for Table and Agenda -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; align-items: start;">
    <!-- Recent Bookings Table Panel -->
    <div class="owner-card" style="margin-bottom: 0; background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);">
            <h4 style="margin: 0; color: var(--primary);">Pemesanan Terbaru</h4>
            <a href="{{ route('owner.bookings.index') }}" class="view-all-link" style="color: var(--secondary); font-weight: 600; text-decoration: none; font-size: 0.85rem;">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div class="table-responsive">
                <table class="owner-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border); font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted);">
                            <th style="padding: 0.75rem 0.5rem; text-align: left;">Penyewa</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: left;">Properti</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: left;">Tanggal</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: left;">Harga</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: left;">Status</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                        <tr style="border-bottom: 1px solid var(--border); font-size: 0.95rem;">
                            <td style="font-weight: 600; color: var(--text-main); padding: 1rem 0.5rem; text-align: left; vertical-align: middle;">{{ $booking->user->name }}</td>
                            <td style="padding: 1rem 0.5rem; text-align: left; vertical-align: middle;">{{ $booking->property->title }}</td>
                            <td style="font-size: 0.9rem; color: var(--text-muted); padding: 1rem 0.5rem; text-align: left; vertical-align: middle; white-space: nowrap;">
                                {{ \Carbon\Carbon::parse($booking->checkin_date)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($booking->checkout_date)->translatedFormat('d M Y') }}
                            </td>
                            <td style="font-weight: 600; color: var(--primary); padding: 1rem 0.5rem; text-align: left; vertical-align: middle; white-space: nowrap;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td style="padding: 1rem 0.5rem; text-align: left; vertical-align: middle;">
                                @if($booking->status === 'Selesai')
                                    <span class="badge badge-success" style="background-color: rgba(34, 197, 94, 0.1); color: #166534; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Selesai</span>
                                @elseif($booking->status === 'Dikonfirmasi')
                                    <span class="badge badge-info" style="background-color: rgba(14, 165, 233, 0.1); color: #0369a1; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Dikonfirmasi</span>
                                @elseif($booking->status === 'Ditolak')
                                    <span class="badge" style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Ditolak</span>
                                @else
                                    <span id="booking-{{ $booking->id }}-status" class="badge badge-warning" style="background-color: rgba(202, 138, 4, 0.1); color: #854d0e; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Menunggu</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if($booking->status === 'Menunggu')
                                    <div id="booking-{{ $booking->id }}-actions" style="display: flex; gap: 0.4rem; align-items: center; justify-content: flex-end;">
                                        <form action="{{ route('owner.bookings.approve', $booking->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="btn-approve" style="background-color: #22c55e; color: white; border: none; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.2rem; transition: var(--transition);">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('owner.bookings.reject', $booking->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="btn-reject" style="background-color: #ef4444; color: white; border: none; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.2rem; transition: var(--transition);">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem 0; color: var(--text-muted); font-size: 0.9rem;">Belum ada pemesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Weekly Agenda Widget -->
    <div class="owner-card" style="margin-bottom: 0; background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
        <div class="card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; color: var(--primary);">Agenda Properti Terdekat</h4>
            <span style="font-size: 0.75rem; font-weight: 700; color: var(--secondary); background: rgba(202, 138, 4, 0.1); padding: 0.25rem 0.5rem; border-radius: 4px;">Pekan Ini</span>
        </div>
        <div class="card-body" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
            <!-- Agenda Timeline -->
            <div style="position: relative; padding-left: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                <!-- Vertical Line -->
                <div style="position: absolute; left: 4px; top: 8px; bottom: 8px; width: 2px; background: var(--border);"></div>

                @forelse($agendaEvents as $event)
                    <!-- Event Item -->
                    <div style="position: relative; display: flex; flex-direction: column; gap: 0.25rem;">
                        <!-- Timeline Node -->
                        <div style="position: absolute; left: -24px; top: 4px; width: 10px; height: 10px; border-radius: 50%; background: {{ $event['color'] }}; border: 3px solid white; box-shadow: 0 0 0 1px {{ $event['color'] }};"></div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">
                            {{ $event['date']->translatedFormat('l, d M') }}
                        </div>
                        <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">
                            {{ $event['type'] }}: <span style="color: var(--primary);">{{ $event['user'] }}</span>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $event['property'] }} ({{ $event['formatted_dates'] }})</div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2rem 0; color: var(--text-muted); font-size: 0.9rem;">Belum ada agenda properti pekan ini.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
function approveBooking(bookingId) {
    if(bookingId === 'clara') {
        const statusEl = document.getElementById('clara-status');
        statusEl.className = 'badge badge-success';
        statusEl.style.backgroundColor = 'rgba(34, 197, 94, 0.1)';
        statusEl.style.color = '#166534';
        statusEl.textContent = 'Dikonfirmasi';
        
        document.getElementById('clara-actions').innerHTML = '<span style="font-size: 0.85rem; color: #22c55e; font-weight: 600; display: inline-flex; align-items: center; gap: 0.2rem;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Diterima</span>';
        
        const badge = document.getElementById('notification-badge');
        if (badge) badge.style.display = 'none';

        showAlert('Pemesanan Villa Canggu oleh Clara Amalia berhasil disetujui!', 'success');
    }
}

function rejectBooking(bookingId) {
    if(bookingId === 'clara') {
        const statusEl = document.getElementById('clara-status');
        statusEl.className = 'badge';
        statusEl.style.backgroundColor = 'rgba(239, 68, 68, 0.1)';
        statusEl.style.color = '#ef4444';
        statusEl.textContent = 'Ditolak';
        
        document.getElementById('clara-actions').innerHTML = '<span style="font-size: 0.85rem; color: #ef4444; font-weight: 600; display: inline-flex; align-items: center; gap: 0.2rem;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Ditolak</span>';
        
        showAlert('Pemesanan Villa Canggu oleh Clara Amalia telah ditolak.', 'danger');
    }
}

function showAlert(message, type) {
    const container = document.getElementById('dashboard-alert-container');
    const alertDiv = document.createElement('div');
    alertDiv.className = `owner-alert owner-alert-${type}`;
    alertDiv.style.marginBottom = '1.5rem';
    alertDiv.style.transition = 'all 0.3s ease';
    
    alertDiv.innerHTML = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg>
        <span>${message}</span>
    `;
    
    container.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.style.opacity = '0';
        setTimeout(() => alertDiv.remove(), 300);
    }, 5000);
}
</script>

@endsection
