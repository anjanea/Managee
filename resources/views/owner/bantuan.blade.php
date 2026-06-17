@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Pusat Bantuan')
@section('page_title', 'Pusat Bantuan & Panduan')

@section('content')

<a href="{{ route('owner.dashboard') }}" class="back-link" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
    <span>Kembali ke Beranda</span>
</a>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start; flex-wrap: wrap;">
    <!-- Accordion FAQ section -->
    <div class="owner-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
        <div class="card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--border);">
            <h4 style="margin: 0; color: var(--primary);">Pertanyaan yang Sering Diajukan (FAQ)</h4>
            <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem; color: var(--text-muted);">Cari jawaban instan untuk pertanyaan umum seputar manajemen properti Anda.</p>
        </div>
        <div class="card-body" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
            @foreach($faqs as $index => $faq)
            <div style="border: 1px solid var(--border); border-radius: var(--radius-md); overflow: hidden;">
                <!-- Header Toggle Button -->
                <button onclick="toggleFaq({{ $index }})" style="width: 100%; text-align: left; padding: 1rem 1.25rem; background: var(--bg-light); border: none; outline: none; display: flex; justify-content: space-between; align-items: center; cursor: pointer; transition: var(--transition);">
                    <span style="font-weight: 600; color: var(--text-main); font-size: 0.95rem; padding-right: 1rem;">{{ $faq['question'] }}</span>
                    <span id="faq-icon-{{ $index }}" style="font-size: 0.9rem; font-weight: 700; color: var(--text-muted); transition: transform 0.2s;">＋</span>
                </button>
                <!-- Collapse Content -->
                <div id="faq-content-{{ $index }}" style="display: none; padding: 1rem 1.25rem; border-top: 1px solid var(--border); font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; background: white;">
                    {{ $faq['answer'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Contact Support Card -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Contact box -->
        <div class="owner-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
            <div style="background: rgba(26, 60, 52, 0.05); color: var(--primary); width: 48px; height: 48px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                🛠️
            </div>
            <div>
                <h4 style="margin: 0 0 0.25rem 0; color: var(--primary);">Butuh bantuan teknis?</h4>
                <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted); line-height: 1.4;">Tim Layanan Pelanggan Managee siap mendampingi kendala operasional Anda 24/7.</p>
            </div>
            
            <div style="border-top: 1px solid var(--border); padding-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                <div style="display: flex; flex-direction: column; gap: 0.15rem;">
                    <span style="color: var(--text-muted);">Surel Bantuan:</span>
                    <strong style="color: var(--primary); font-size: 0.95rem;">bantuan@managee.id</strong>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.15rem;">
                    <span style="color: var(--text-muted);">Kontak WA:</span>
                    <strong style="color: var(--primary); font-size: 0.95rem;">0812-8899-7766</strong>
                </div>
            </div>

            <button onclick="alert('Layanan obrolan langsung sedang dipersiapkan!')" class="btn" style="background: var(--secondary); color: white; border: none; padding: 0.6rem; border-radius: var(--radius-md); font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: var(--transition); text-align: center;">Hubungi Obrolan Langsung</button>
        </div>
    </div>
</div>

<script>
    function toggleFaq(index) {
        const content = document.getElementById(`faq-content-${index}`);
        const icon = document.getElementById(`faq-icon-${index}`);
        
        const isHidden = content.style.display === 'none';
        
        // Hide all first to achieve accordion style
        for (let i = 0; i < {{ count($faqs) }}; i++) {
            document.getElementById(`faq-content-${i}`).style.display = 'none';
            document.getElementById(`faq-icon-${i}`).textContent = '＋';
            document.getElementById(`faq-icon-${i}`).style.transform = 'rotate(0deg)';
        }

        if (isHidden) {
            content.style.display = 'block';
            icon.textContent = '－';
            icon.style.transform = 'rotate(180deg)';
        }
    }
</script>

@endsection
