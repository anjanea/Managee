@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Ulasan Tamu')
@section('page_title', 'Ulasan & Rating Penyewa')

@section('content')

<a href="{{ route('owner.dashboard') }}" class="back-link" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
    <span>Kembali ke Beranda</span>
</a>

@if(session('success'))
    <div class="owner-alert owner-alert-success" style="margin-bottom: 2rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="owner-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
    <div class="card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <h4 style="margin: 0; color: var(--primary);">Semua Masukan & Bintang Properti</h4>
    </div>
    
    <div class="card-body" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
        @forelse($reviews as $rev)
        <div class="review-box" style="border: 1px solid var(--border); border-radius: var(--radius-md); padding: 1.25rem; background: var(--bg-light); display: flex; flex-direction: column; gap: 0.75rem;">
            <!-- Review Header Info -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.5rem;">
                <div>
                    <h5 style="margin: 0 0 0.15rem 0; color: var(--text-main); font-weight: 700; font-size: 1rem;">{{ $rev->user->name }}</h5>
                    <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">Properti: <strong style="color: var(--primary);">{{ $rev->property->title }}</strong></span>
                </div>
                <div style="text-align: right;">
                    <!-- Stars Rating -->
                    <div style="color: #fbbf24; font-size: 1rem; margin-bottom: 0.15rem;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rev->stars)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $rev->created_at->format('d M Y') }}</span>
                </div>
            </div>
            
            <!-- Comment text -->
            <p style="margin: 0; font-size: 0.95rem; color: var(--text-main); line-height: 1.4;">
                {{ $rev->comment }}
            </p>

            <!-- Reply Box Section -->
            <div style="margin-top: 0.5rem; border-top: 1px dotted var(--border); padding-top: 0.75rem;">
                @if($rev->reply)
                    <!-- Display Reply -->
                    <div id="reply-display-{{ $rev->id }}" style="background: rgba(26, 60, 52, 0.05); border-left: 3px solid var(--primary); padding: 0.75rem 1rem; border-radius: 0 var(--radius-md) var(--radius-md) 0; display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                        <div style="flex: 1;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 0.15rem;">Balasan Anda:</span>
                            <p style="margin: 0; font-size: 0.9rem; color: var(--text-main); font-style: italic;">{{ $rev->reply }}</p>
                        </div>
                        <div style="display: flex; gap: 0.5rem; align-items: center; flex-shrink: 0;">
                            <button onclick="toggleEditForm({{ $rev->id }}, true)" style="background: none; border: 1px solid var(--border); color: var(--primary); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: var(--transition);">Ubah</button>
                            <button type="button" onclick="confirmDeleteReply('{{ $rev->id }}')" style="background: none; border: 1px solid #fee2e2; color: #ef4444; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: var(--transition);" onmouseover="this.style.backgroundColor='#fee2e2'" onmouseout="this.style.backgroundColor='transparent'">Hapus</button>
                        </div>
                    </div>

                    <!-- Edit Form (hidden by default) -->
                    <div id="reply-edit-form-{{ $rev->id }}" style="display: none; flex-direction: column; gap: 0.5rem; max-width: 600px;">
                        <form action="{{ route('owner.ulasan.reply', $rev->id) }}" method="POST" style="margin:0; display: flex; flex-direction: column; gap: 0.5rem;">
                            @csrf
                            <label style="font-size: 0.75rem; font-weight: 700; color: var(--primary);">Ubah Balasan Anda:</label>
                            <textarea name="reply" rows="2" style="width: 100%; box-sizing: border-box; padding: 0.5rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.85rem; outline: none; resize: vertical;" required>{{ $rev->reply }}</textarea>
                            <div style="display: flex; gap: 0.5rem;">
                                <button type="submit" style="background: var(--primary); color: white; border: none; padding: 0.4rem 1rem; border-radius: 4px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: var(--transition);">Simpan</button>
                                <button type="button" onclick="toggleEditForm({{ $rev->id }}, false)" style="background: white; border: 1px solid var(--border); color: var(--text-muted); padding: 0.4rem 1rem; border-radius: 4px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: var(--transition);">Batal</button>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Create Reply Form -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; max-width: 600px;">
                        <form action="{{ route('owner.ulasan.reply', $rev->id) }}" method="POST" style="margin:0; display: flex; flex-direction: column; gap: 0.5rem;">
                            @csrf
                            <textarea name="reply" placeholder="Tulis tanggapan atau ucapan terima kasih kepada penyewa..." rows="2" style="width: 100%; box-sizing: border-box; padding: 0.5rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.85rem; outline: none; resize: vertical;" required></textarea>
                            <div>
                                <button type="submit" style="background: var(--primary); color: white; border: none; padding: 0.4rem 1rem; border-radius: 4px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: var(--transition);">Kirim Balasan</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 3rem 0; color: var(--text-muted);">Belum ada ulasan masuk.</div>
        @endforelse
    </div>
</div>

<script>
    function toggleEditForm(id, show) {
        const displayDiv = document.getElementById(`reply-display-${id}`);
        const editDiv = document.getElementById(`reply-edit-form-${id}`);
        if (show) {
            displayDiv.style.display = 'none';
            editDiv.style.display = 'flex';
        } else {
            displayDiv.style.display = 'flex';
            editDiv.style.display = 'none';
        }
    }
    function confirmDeleteReply(id) {
        const form = document.getElementById('delete-reply-form');
        form.action = `/owner/ulasan/${id}/balas/hapus`;
        document.getElementById('delete-reply-modal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('delete-reply-modal').style.display = 'none';
    }
</script>

<div id="delete-reply-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: #FFFFFF; border-radius: 16px; padding: 2rem; max-width: 450px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); text-align: center; border: 1px solid var(--border); animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        <!-- Warning Icon -->
        <div style="background: #FEE2E2; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem auto; color: #EF4444;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; font-family: 'Outfit', sans-serif;">Konfirmasi Hapus Balasan</h3>
        <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1.75rem;">
            Apakah Anda yakin ingin menghapus balasan ulasan ini? Tindakan ini tidak dapat dibatalkan.
        </p>
        <div style="display: flex; gap: 0.75rem; justify-content: center;">
            <button type="button" onclick="closeDeleteModal()" style="background: #f1f5f9; color: var(--text-main); border: 1px solid var(--border); padding: 0.6rem 1.5rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; font-size: 0.9rem; font-family: inherit;">Batal</button>
            <form id="delete-reply-form" action="" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #ef4444; color: white; border: none; padding: 0.6rem 1.5rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; font-size: 0.9rem; font-family: inherit;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

@endsection
