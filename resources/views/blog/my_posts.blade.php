@extends('layouts.app')

@section('title', 'Managee - Artikel Saya')

@section('content')
<style>
    :root {
        --emerald-primary: #1A3C34;
        --emerald-light: #2D6A4F;
        --emerald-glow: rgba(45, 106, 79, 0.15);
        --secondary-gold: #CA8A04;
        --secondary-gold-light: #EAB308;
        --text-dark: #1E293B;
        --text-slate: #475569;
        --text-light-slate: #64748B;
        --border-color: #E2E8F0;
        --card-bg: #FFFFFF;
        --bg-light-gray: #F8FAFC;
    }

    .my-blog-container {
        padding-top: 100px;
        padding-bottom: 5rem;
        background-color: var(--bg-light-gray);
        font-family: 'Outfit', sans-serif;
        min-height: 90vh;
    }

    .my-blog-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: none;
        border: none;
        color: var(--text-light-slate);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        padding: 0;
        margin-bottom: 1.5rem;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .back-button:hover {
        color: var(--emerald-light);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin: 0;
    }

    .page-subtitle {
        font-size: 0.9rem;
        color: var(--text-slate);
        margin: 0.25rem 0 0 0;
    }

    .btn-write-new {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: var(--secondary-gold);
        color: #FFFFFF;
        padding: 0.7rem 1.5rem;
        border-radius: 9999px;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(202, 138, 4, 0.15);
        transition: all 0.25s ease;
    }

    .btn-write-new:hover {
        background-color: var(--secondary-gold-light);
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(202, 138, 4, 0.25);
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 600;
        border-radius: 9999px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-kuliner { background-color: #FAE8FF; color: #A855F7; }
    .badge-wisata { background-color: #E0F2FE; color: #0284C7; }
    .badge-hukum { background-color: #FEE2E2; color: #EF4444; }
    .badge-dekorasi { background-color: #FEF3C7; color: #D97706; }
    .badge-perawatan { background-color: #DCFCE7; color: #16A34A; }
    .badge-penyewa { background-color: #ECEFFF; color: #4F46E5; }

    .compact-blog-row {
        display: flex;
        gap: 1.25rem;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.2s;
        align-items: center;
        position: relative;
        margin-bottom: 1rem;
    }

    .compact-blog-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border-color: rgba(45, 106, 79, 0.15);
    }

    .row-image {
        width: 90px;
        height: 90px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #E2E8F0;
    }

    .row-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .row-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        padding-right: 120px; /* Leave space for actions */
    }

    .row-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--emerald-primary);
        line-height: 1.3;
    }

    .row-excerpt {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-slate);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }

    .row-actions {
        position: absolute;
        right: 1.25rem;
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border: none;
        transition: all 0.2s;
    }

    .edit-btn {
        background-color: var(--emerald-glow);
        color: var(--emerald-light);
    }

    .edit-btn:hover {
        background-color: var(--emerald-primary);
        color: #FFFFFF;
    }

    .delete-btn {
        background-color: #FEE2E2;
        color: #EF4444;
    }

    .delete-btn:hover {
        background-color: #EF4444;
        color: #FFFFFF;
    }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background-color: var(--card-bg);
        border-radius: 16px;
        border: 1px dashed var(--border-color);
        margin-top: 1rem;
    }
</style>

<div class="my-blog-container">
    <div class="my-blog-wrapper">

        <!-- Back Button -->
        <a href="{{ route('blog.public') }}" class="back-button">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Kembali ke Blog Publik</span>
        </a>

        @if(session('success'))
            <div style="background-color: #DCFCE7; border: 1px solid #BBF7D0; color: #16A34A; padding: 1rem 1.5rem; border-radius: 12px; font-weight: 600; margin-bottom: 1.5rem;">
                ✓ {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Artikel Saya</h1>
                <p class="page-subtitle">Kelola dan ubah artikel panduan properti yang pernah Anda tulis.</p>
            </div>
            <a href="{{ route('blog.create_public') }}" class="btn-write-new">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                <span>Tulis Artikel Baru</span>
            </a>
        </div>

        <!-- My Articles List -->
        @if($posts->count() > 0)
            <div style="display: flex; flex-direction: column;">
                @foreach($posts as $post)
                    @php
                        $badgeClass = 'badge-penyewa';
                        if ($post->category == 'Kuliner') $badgeClass = 'badge-kuliner';
                        elseif ($post->category == 'Lainnya' || $post->category == 'Tempat Wisata') $badgeClass = 'badge-wisata';
                        elseif ($post->category == 'Hukum & Regulasi' || $post->category == 'Hukum') $badgeClass = 'badge-hukum';
                        elseif ($post->category == 'Dekorasi & Renovasi') $badgeClass = 'badge-dekorasi';
                        elseif ($post->category == 'Perawatan & Fasilitas') $badgeClass = 'badge-perawatan';
                        elseif ($post->category == 'Panduan Penyewa') $badgeClass = 'badge-penyewa';
                        elseif ($post->category == 'Panduan Pemilik' || $post->category == 'Tips Sewa' || $post->category == 'Strategi Bisnis') $badgeClass = 'badge-perawatan';
                    @endphp
                    <article class="compact-blog-row">
                        <div class="row-image">
                            <img src="{{ $post->image ?: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600' }}" alt="{{ $post->title }}">
                        </div>
                        <div class="row-content">
                            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                <span class="badge {{ $badgeClass }}">{{ $post->category }}</span>
                                <span style="font-size: 0.75rem; color: var(--text-light-slate);">
                                    👁️ {{ $post->views }} Kali Dilihat • 📅 {{ $post->created_at ? $post->created_at->translatedFormat("d M Y") : "Baru Saja" }}
                                </span>
                            </div>
                            <h3 class="row-title">{{ $post->title }}</h3>
                            <p class="row-excerpt">
                                {{ $post->summary ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 120, '...') }}
                            </p>
                        </div>
                        <div class="row-actions">
                            <a href="{{ route('blog.edit_public', $post->slug) }}" class="action-btn edit-btn" title="Ubah Artikel">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                <span>Edit</span>
                            </a>
                            <button type="button" onclick="confirmDeletePublic('{{ $post->slug }}', '{{ addslashes($post->title) }}')" class="action-btn delete-btn" title="Hapus Artikel">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-light-slate)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1.5rem;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <h3 style="color: var(--emerald-primary); margin-bottom: 0.5rem;">Belum Ada Artikel</h3>
                <p style="color: var(--text-slate); font-size: 0.95rem; max-width: 480px; margin: 0 auto 1.5rem auto; line-height: 1.5;">
                    Anda belum menulis artikel apapun. Ayo, bagikan panduan seputar hunian, kuliner sekitar, atau tips menarik lainnya!
                </p>
                <a href="{{ route('blog.create_public') }}" class="btn-write-new">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                    <span>Tulis Artikel Sekarang</span>
                </a>
            </div>
        @endif

    </div>
</div>

<!-- Centered Delete Confirmation Modal -->
<div id="delete-confirm-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: #FFFFFF; border-radius: 16px; padding: 2rem; max-width: 450px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); text-align: center; border: 1px solid var(--border-color); animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <!-- Warning Icon -->
        <div style="background: #FEE2E2; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem auto; color: #EF4444;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>

        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--emerald-primary); margin-bottom: 0.5rem;">Konfirmasi Hapus Artikel</h3>
        <p style="font-size: 0.9rem; color: var(--text-slate); line-height: 1.5; margin-bottom: 1.75rem;">
            Apakah Anda yakin ingin menghapus artikel <strong id="delete-post-title" style="color: var(--text-dark);"></strong>? Tindakan ini tidak dapat dibatalkan.
        </p>

        <!-- Hidden Form -->
        <form id="delete-post-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 0.75rem; justify-content: center;">
                <button type="button" onclick="closeDeleteModal()" style="background-color: #FFFFFF; color: var(--text-slate); border: 1px solid var(--text-slate); font-family: inherit; font-size: 0.9rem; font-weight: 700; padding: 0.65rem 1.5rem; border-radius: 8px; cursor: pointer; width: 100%; transition: all 0.2s ease;">
                    Batal
                </button>
                <button type="submit" style="background-color: #EF4444; color: #FFFFFF; border: none; font-family: inherit; font-size: 0.9rem; font-weight: 700; padding: 0.65rem 1.5rem; border-radius: 8px; cursor: pointer; width: 100%; transition: all 0.2s ease; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmDeletePublic(slug, title) {
        const modal = document.getElementById('delete-confirm-modal');
        const titleSpan = document.getElementById('delete-post-title');
        const form = document.getElementById('delete-post-form');
        
        titleSpan.textContent = `"${title}"`;
        form.action = `/blog/${slug}/hapus`;
        
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-confirm-modal');
        modal.style.display = 'none';
    }
</script>
@endsection
