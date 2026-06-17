@extends('layouts.owner')

@section('title', 'Managee Owner Dashboard - ' . $post->title)
@section('page_title', 'Baca Artikel')

@section('content')

<div class="owner-blog-detail-container">
    <a href="{{ route('owner.blog.index') }}" class="back-link" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        <span>Kembali ke Daftar Artikel</span>
    </a>

    <div class="blog-detail-header">
        <span class="blog-detail-category-badge">{{ $post->category }}</span>
        <h1 class="blog-detail-title" style="margin-top: 0.75rem; font-size: 2.2rem; color: var(--primary); font-weight: 700; line-height: 1.2;">{{ $post->title }}</h1>
        
        <div class="blog-detail-meta" style="display: flex; gap: 1.5rem; margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem;">
            <span>Oleh: <strong>{{ $post->author }}</strong></span>
            <span>Dipublikasikan: <strong>{{ $post->created_at->format('d M Y, H:i') }} WIB</strong></span>
        </div>
    </div>

    @if($post->image)
        <div class="blog-detail-image-wrapper" style="margin: 2rem 0; border-radius: var(--radius-lg); overflow: hidden; max-height: 400px; width: 100%;">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    @endif

    <div class="blog-detail-content" style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main); font-family: inherit;">
        {!! nl2br(e($post->content)) !!}
    </div>
</div>

@endsection
