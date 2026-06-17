@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Ulasan Tamu')
@section('page_title', 'Ulasan & Rating Penyewa')

@section('content')

<a href="{{ route('owner.dashboard') }}" class="back-link" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
    <span>Kembali ke Beranda</span>
</a>

<div class="owner-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
    <div class="card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <h4 style="margin: 0; color: var(--primary);">Semua Masukan & Bintang Properti</h4>
    </div>
    
    <div class="card-body" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
        @foreach($reviews as $index => $rev)
        <div class="review-box" style="border: 1px solid var(--border); border-radius: var(--radius-md); padding: 1.25rem; background: var(--bg-light); display: flex; flex-direction: column; gap: 0.75rem;">
            <!-- Review Header Info -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.5rem;">
                <div>
                    <h5 style="margin: 0 0 0.15rem 0; color: var(--text-main); font-weight: 700; font-size: 1rem;">{{ $rev['tenant_name'] }}</h5>
                    <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">Properti: <strong style="color: var(--primary);">{{ $rev['property_title'] }}</strong></span>
                </div>
                <div style="text-align: right;">
                    <!-- Stars Rating -->
                    <div style="color: #fbbf24; font-size: 1rem; margin-bottom: 0.15rem;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rev['stars'])
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $rev['date'] }}</span>
                </div>
            </div>
            
            <!-- Comment text -->
            <p style="margin: 0; font-size: 0.95rem; color: var(--text-main); line-height: 1.4;">
                {{ $rev['comment'] }}
            </p>

            <!-- Reply Box Section -->
            <div id="reply-container-{{ $index }}" style="margin-top: 0.5rem; border-top: 1px dotted var(--border); padding-top: 0.75rem;">
                @if($rev['reply'])
                    <div style="background: rgba(26, 60, 52, 0.05); border-left: 3px solid var(--primary); padding: 0.75rem 1rem; border-radius: 0 var(--radius-md) var(--radius-md) 0;">
                        <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 0.15rem;">Balasan Anda:</span>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--text-main); font-style: italic;">{{ $rev['reply'] }}</p>
                    </div>
                @else
                    <div id="reply-form-{{ $index }}" style="display: flex; flex-direction: column; gap: 0.5rem; max-width: 600px;">
                        <textarea id="reply-text-{{ $index }}" placeholder="Tulis tanggapan atau ucapan terima kasih kepada penyewa..." rows="2" style="width: 100%; box-sizing: border-box; padding: 0.5rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.85rem; outline: none; resize: vertical;"></textarea>
                        <div>
                            <button onclick="submitReply({{ $index }})" style="background: var(--primary); color: white; border: none; padding: 0.4rem 1rem; border-radius: 4px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: var(--transition);">Kirim Balasan</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function submitReply(index) {
        const replyTextEl = document.getElementById(`reply-text-${index}`);
        const replyText = replyTextEl.value.trim();

        if (!replyText) {
            alert('Silakan tulis tanggapan terlebih dahulu.');
            return;
        }

        const container = document.getElementById(`reply-container-${index}`);
        container.innerHTML = `
            <div style="background: rgba(26, 60, 52, 0.05); border-left: 3px solid var(--primary); padding: 0.75rem 1rem; border-radius: 0 var(--radius-md) var(--radius-md) 0; animation: fadeIn 0.3s ease-out;">
                <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 0.15rem;">Balasan Anda:</span>
                <p style="margin: 0; font-size: 0.9rem; color: var(--text-main); font-style: italic;">${replyText}</p>
            </div>
        `;
        
        alert('Tanggapan ulasan berhasil dipublikasikan!');
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@endsection
