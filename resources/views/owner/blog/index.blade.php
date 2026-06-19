@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Artikel Blog')
@section('page_title', 'Kelola Blog')

@section('content')

<style>
@keyframes modalFadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
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

<!-- Search and Category Filters -->
<div class="owner-search-filter-section" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 2rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; gap: 1.25rem;">
    <div style="display: flex; gap: 1rem; align-items: center; width: 100%; flex-wrap: wrap;">
        <div style="position: relative; flex: 1; min-width: 280px;">
            <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); display: flex; align-items: center; pointer-events: none;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </span>
            <input type="text" id="blog-search-input" placeholder="Cari artikel, penulis, atau topik..." style="width: 100%; padding: 0.85rem 1rem 0.85rem 3rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.95rem; outline: none; transition: var(--transition); background: var(--bg-light);" oninput="filterBlogs()">
        </div>
        
        <a href="{{ route('owner.blog.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; padding: 0.85rem 1.5rem; font-size: 0.95rem; font-weight: 600; border-radius: var(--radius-md); background-color: var(--secondary); color: white; border: none; box-shadow: var(--shadow-sm); cursor: pointer; transition: var(--transition); white-space: nowrap;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>Buat Artikel Baru</span>
        </a>
    </div>
    
    <!-- Horizontal Scrollable Category Pills -->
    <div class="category-pills-container" style="display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 0.5rem; scrollbar-width: thin; -ms-overflow-style: none;">
        <button class="category-pill active" data-category="Semua" onclick="selectCategory(this)" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1.25rem; border-radius: var(--radius-full); font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: var(--transition); white-space: nowrap;">Semua Artikel</button>
        @php
            $categories = ['Panduan Pemilik', 'Panduan Penyewa', 'Hukum & Regulasi', 'Dekorasi & Renovasi', 'Kuliner', 'Perawatan & Fasilitas', 'Lainnya'];
        @endphp
        @foreach($categories as $cat)
            <button class="category-pill" data-category="{{ $cat }}" onclick="selectCategory(this)" style="background: var(--bg-light); color: var(--text-muted); border: 1px solid var(--border); padding: 0.5rem 1.25rem; border-radius: var(--radius-full); font-weight: 500; font-size: 0.85rem; cursor: pointer; transition: var(--transition); white-space: nowrap;">{{ $cat }}</button>
        @endforeach
    </div>
</div>

<!-- Tabs Controls -->
<div class="owner-tabs">
    <button class="tab-link active" onclick="openTab(event, 'jelajahi-artikel')">Jelajahi Artikel</button>
    <button class="tab-link" onclick="openTab(event, 'artikel-saya')">Artikel Saya ({{ $myPosts->count() }})</button>
</div>

<!-- Tab 1: Jelajahi Artikel -->
<div id="jelajahi-artikel" class="tab-panel active">
    @if($othersPosts->count() > 0 || $myPosts->count() > 0)
        <div class="owner-blog-grid">
            @foreach($othersPosts->concat($myPosts)->sortByDesc('created_at') as $post)
                <article class="owner-blog-card" style="position: relative;">
                    <div class="card-image-wrapper">
                        <img src="{{ $post->image }}" alt="{{ $post->title }}">
                        <span class="card-category-badge">{{ $post->category }}</span>
                        @if($post->is_own)
                            <span class="card-own-badge" style="position: absolute; top: 1rem; right: 1rem; background-color: var(--primary); color: white; font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid rgba(255,255,255,0.2);">Artikel Anda</span>
                        @endif
                    </div>
                    <div class="card-content">
                        <h4 class="card-title" style="font-size: 1.1rem; font-weight: 700; height: 2.8rem; overflow: hidden; line-height: 1.4; color: var(--primary);">{{ $post->title }}</h4>
                        <div class="card-meta" style="margin-bottom: 0.75rem;">
                            <span class="card-author">Oleh: {{ $post->is_own ? 'Anda' : $post->author }}</span>
                            <span class="card-date">{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <p class="card-excerpt">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                        
                        <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--border);">
                            <a href="{{ route('owner.blog.show', $post->slug) }}" class="btn-read-more" style="display: inline-flex; align-items: center; gap: 0.25rem;">
                                <span>Baca Selengkapnya</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="owner-empty-state">
            <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" stroke-width="1.5" fill="none" style="opacity: 0.5;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
            <p>Belum ada artikel apapun yang terbit.</p>
        </div>
    @endif
</div>

<!-- Tab 2: Artikel Saya -->
<div id="artikel-saya" class="tab-panel">
    @if($myPosts->count() > 0)
        <div class="owner-blog-grid">
            @foreach($myPosts as $post)
                <article class="owner-blog-card">
                    <div class="card-image-wrapper">
                        <img src="{{ $post->image }}" alt="{{ $post->title }}">
                        <span class="card-category-badge">{{ $post->category }}</span>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title" style="font-size: 1.1rem; font-weight: 700; height: 2.8rem; overflow: hidden; line-height: 1.4; color: var(--primary);">{{ $post->title }}</h4>
                        <div class="card-meta" style="margin-bottom: 0.75rem;">
                            <span class="card-author">Oleh: Anda</span>
                            <span class="card-date">{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <p class="card-excerpt">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                        
                        <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--border);">
                            <a href="{{ route('owner.blog.show', $post->slug) }}" class="btn-read-more">Baca</a>
                            
                            <div style="display: flex; gap: 0.35rem; align-items: center;">
                                <a href="{{ route('owner.blog.edit', $post->slug) }}" class="btn btn-action-edit" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; text-decoration: none;">Ubah</a>
                                <button type="button" onclick="confirmDeleteArticle('{{ $post->slug }}', '{{ addslashes($post->title) }}')" class="btn btn-action-delete" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; cursor: pointer;">Hapus</button>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="owner-empty-state" style="padding: 4rem 2rem;">
            <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" stroke-width="1.5" fill="none" style="opacity: 0.5; margin-bottom: 1rem;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <h4>Anda belum pernah memposting artikel</h4>
            <p style="margin-top: 0.5rem; color: var(--text-muted);">Bagikan ide pertamamu seputar sewa villa, apartemen, atau properti lainnya hari ini.</p>
            <a href="{{ route('owner.blog.create') }}" class="btn btn-outline" style="margin-top: 1.5rem; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Tulis Artikel Pertama</span>
            </a>
        </div>
    @endif
</div>

<!-- Modal -->
<div id="delete-article-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: #FFFFFF; border-radius: 16px; padding: 2rem; max-width: 450px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); text-align: center; border: 1px solid var(--border); animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        <!-- Warning Icon -->
        <div style="background: #FEE2E2; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem auto; color: #EF4444;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; font-family: 'Outfit', sans-serif;">Konfirmasi Hapus Artikel</h3>
        <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1.75rem;">
            Apakah Anda yakin ingin menghapus artikel <strong id="delete-article-title-modal" style="color: var(--text-main);"></strong>? Tindakan ini tidak dapat dibatalkan.
        </p>
        <div style="display: flex; gap: 0.75rem; justify-content: center;">
            <button type="button" onclick="closeDeleteModal()" class="btn" style="background: #f1f5f9; color: var(--text-main); border: 1px solid var(--border); padding: 0.6rem 1.5rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; font-size: 0.9rem;">Batal</button>
            <form id="delete-article-form" action="" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background: #ef4444; color: white; border: none; padding: 0.6rem 1.5rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; font-size: 0.9rem;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<!-- Tab Script and Filter Script -->
<script>
    let activeCategory = 'Semua';

    function confirmDeleteArticle(slug, title) {
        const form = document.getElementById('delete-article-form');
        form.action = `/owner/blog/${slug}`;
        document.getElementById('delete-article-title-modal').textContent = title;
        document.getElementById('delete-article-modal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('delete-article-modal').style.display = 'none';
    }

    function openTab(evt, tabId) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tab-panel");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.remove("active");
        }

        tablinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }

        document.getElementById(tabId).classList.add("active");
        evt.currentTarget.classList.add("active");
        
        filterBlogs();
    }

    function selectCategory(buttonElement) {
        // Remove active class from all pills
        document.querySelectorAll('.category-pill').forEach(btn => {
            btn.classList.remove('active');
            btn.style.background = 'var(--bg-light)';
            btn.style.color = 'var(--text-muted)';
            btn.style.border = '1px solid var(--border)';
        });
        
        // Add active class to clicked pill
        buttonElement.classList.add('active');
        buttonElement.style.background = 'var(--primary)';
        buttonElement.style.color = 'white';
        buttonElement.style.border = 'none';
        
        activeCategory = buttonElement.getAttribute('data-category');
        filterBlogs();
    }

    function filterBlogs() {
        const searchQuery = document.getElementById('blog-search-input').value.toLowerCase().trim();
        
        // Select all cards across all tabs
        const cards = document.querySelectorAll('.owner-blog-card');
        
        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const excerpt = card.querySelector('.card-excerpt').textContent.toLowerCase();
            const author = card.querySelector('.card-author').textContent.toLowerCase();
            const category = card.querySelector('.card-category-badge').textContent.trim();
            
            const matchesSearch = title.includes(searchQuery) || excerpt.includes(searchQuery) || author.includes(searchQuery);
            const matchesCategory = (activeCategory === 'Semua') || (category === activeCategory);
            
            if (matchesSearch && matchesCategory) {
                card.style.style = ''; // Reset display
                card.style.setProperty('display', 'flex', 'important');
            } else {
                card.style.setProperty('display', 'none', 'important');
            }
        });
        
        // Show empty state inside active tab panel if all cards are hidden
        const activePanel = document.querySelector('.tab-panel.active');
        const visibleCards = activePanel.querySelectorAll('.owner-blog-card[style*="display: flex"]');
        let emptyState = activePanel.querySelector('.dynamic-empty-state');
        
        if (visibleCards.length === 0) {
            if (!emptyState) {
                emptyState = document.createElement('div');
                emptyState.className = 'owner-empty-state dynamic-empty-state';
                emptyState.style.padding = '4rem 2rem';
                emptyState.style.textAlign = 'center';
                emptyState.innerHTML = `
                    <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" stroke-width="1.5" fill="none" style="opacity: 0.5; margin-bottom: 1rem; display: inline-block;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <p>Tidak ada artikel yang cocok dengan pencarian Anda.</p>
                `;
                activePanel.appendChild(emptyState);
            } else {
                emptyState.style.display = 'block';
            }
            const grid = activePanel.querySelector('.owner-blog-grid');
            if (grid) grid.style.display = 'none';
        } else {
            if (emptyState) {
                emptyState.style.display = 'none';
            }
            const grid = activePanel.querySelector('.owner-blog-grid');
            if (grid) grid.style.display = 'grid';
        }
    }
</script>

@endsection
