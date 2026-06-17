@extends('layouts.app')

@section('title', 'Managee - Ubah Blog')

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
        
        /* Matching the mockup inputs background color */
        --mockup-input-bg: #F1ECE3; 
        --mockup-input-hover: #EBE5DB;
    }

    .write-blog-page {
        padding-top: 100px;
        padding-bottom: 5rem;
        background-color: #FFFFFF; /* Pure white background to match mockup */
        min-height: 90vh;
        font-family: 'Outfit', sans-serif;
    }

    .write-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* Modal-like Header */
    .mock-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 1.5rem;
        border-bottom: 1.5px solid var(--border-color);
        margin-bottom: 2rem;
    }

    .mock-header-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .mock-header-subtitle {
        font-size: 0.88rem;
        color: var(--text-light-slate);
        margin: 0.25rem 0 0 0;
    }

    .close-modal-btn {
        color: var(--text-dark);
        transition: transform 0.2s ease, color 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
    }

    .close-modal-btn:hover {
        color: #EF4444;
        transform: scale(1.1);
    }

    /* Form Fields Styling */
    .mock-form-group {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
        margin-bottom: 1.75rem;
    }

    .mock-label {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .mock-input {
        width: 100%;
        background-color: var(--mockup-input-bg);
        border: none;
        border-radius: 12px;
        padding: 0.9rem 1.25rem;
        font-family: inherit;
        font-size: 0.95rem;
        color: var(--text-dark);
        outline: none;
        transition: all 0.2s ease;
    }

    .mock-input::placeholder {
        color: #A09C94;
    }

    .mock-input:focus {
        background-color: var(--mockup-input-hover);
        box-shadow: 0 0 0 2px var(--emerald-glow);
    }

    .mock-textarea {
        resize: vertical;
        min-height: 100px;
        line-height: 1.5;
    }

    .mock-textarea-content {
        min-height: 180px;
    }

    /* Category Chips Form Selection */
    .category-chips-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        margin-bottom: 0.5rem;
    }

    .category-form-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 1.1rem;
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-full);
        font-family: inherit;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-slate);
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
    }

    .category-form-chip svg {
        stroke: var(--text-slate);
        flex-shrink: 0;
    }

    .category-form-chip:hover {
        border-color: var(--text-slate);
        background-color: var(--bg-light-gray);
        transform: translateY(-1px);
    }

    .category-form-chip.active {
        background-color: var(--emerald-primary);
        border-color: var(--emerald-primary);
        color: #FFFFFF;
        box-shadow: 0 4px 10px rgba(26, 60, 52, 0.15);
    }

    .category-form-chip.active svg {
        stroke: #FFFFFF;
    }

    /* File / Image Upload Box style */
    .upload-box {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background-color: var(--mockup-input-bg);
        border-radius: 12px;
        padding: 0.9rem 1.25rem;
        color: #7A766F;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .upload-box:hover {
        background-color: var(--mockup-input-hover);
    }

    .upload-box svg {
        color: #7A766F;
    }

    /* Footer Buttons Row */
    .mock-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 0.75rem;
        padding-top: 1.5rem;
        border-top: 1.5px solid var(--border-color);
        margin-top: 2.5rem;
    }

    .btn-mock-cancel {
        background-color: #FFFFFF;
        color: var(--text-slate);
        border: 1px solid var(--text-slate);
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 700;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        text-align: center;
    }

    .btn-mock-cancel:hover {
        background-color: var(--bg-light-gray);
        color: var(--text-dark);
    }

    .btn-mock-submit {
        background-color: var(--emerald-primary);
        color: #FFFFFF;
        border: none;
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 700;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(26, 60, 52, 0.15);
    }

    .btn-mock-submit:hover {
        background-color: var(--emerald-light);
        transform: translateY(-1px);
    }

    .form-error-msg {
        color: #EF4444;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 0.25rem;
    }
</style>

<div class="write-blog-page">
    <div class="write-container">
        
        <!-- Header -->
        <div class="mock-header">
            <div>
                <h1 class="mock-header-title">Ubah Blog</h1>
                <p class="mock-header-subtitle">Edit rincian artikel di bawah ini untuk memperbarui panduan Anda.</p>
            </div>
            <a href="{{ $backUrl }}" class="close-modal-btn">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>
        </div>

        <form action="{{ route('blog.update_public', $post->slug) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="back_url" value="{{ $backUrl }}">

            <!-- Category Field (Visual Selection) -->
            <div class="mock-form-group">
                <label class="mock-label">Kategori</label>
                <input type="hidden" name="category" id="selected-category" value="{{ old('category', $post->category) }}" required oninvalid="this.setCustomValidity('Silakan pilih kategori.')" oninput="this.setCustomValidity('')">
                
                <div class="category-chips-grid">
                    <button type="button" class="category-form-chip {{ old('category', $post->category) === 'Panduan Pemilik' ? 'active' : '' }}" data-value="Panduan Pemilik">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Panduan Pemilik</span>
                    </button>
                    <button type="button" class="category-form-chip {{ old('category', $post->category) === 'Panduan Penyewa' ? 'active' : '' }}" data-value="Panduan Penyewa">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        <span>Panduan Penyewa</span>
                    </button>
                    <button type="button" class="category-form-chip {{ old('category', $post->category) === 'Hukum & Regulasi' ? 'active' : '' }}" data-value="Hukum & Regulasi">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span>Hukum & Regulasi</span>
                    </button>
                    <button type="button" class="category-form-chip {{ old('category', $post->category) === 'Dekorasi & Renovasi' ? 'active' : '' }}" data-value="Dekorasi & Renovasi">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span>Dekorasi & Renovasi</span>
                    </button>
                    <button type="button" class="category-form-chip {{ old('category', $post->category) === 'Kuliner' ? 'active' : '' }}" data-value="Kuliner">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8V21M12 2v20M6 2v6M6 2a4 4 0 0 0 4 4M10 2a4 4 0 0 1 4 4"/></svg>
                        <span>Kuliner</span>
                    </button>
                    <button type="button" class="category-form-chip {{ old('category', $post->category) === 'Perawatan & Fasilitas' ? 'active' : '' }}" data-value="Perawatan & Fasilitas">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                        <span>Perawatan & Fasilitas</span>
                    </button>
                    <button type="button" class="category-form-chip {{ old('category', $post->category) === 'Lainnya' ? 'active' : '' }}" data-value="Lainnya">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        <span>Lainnya</span>
                    </button>
                </div>
                @error('category')
                    <span class="form-error-msg">{{ $message }}</span>
                @enderror
            </div>

            <!-- Title Input -->
            <div class="mock-form-group">
                <label for="title" class="mock-label">Judul Artikel</label>
                <input type="text" name="title" id="title" class="mock-input" placeholder="Tulis judul yang menarik perhatian..." value="{{ old('title', $post->title) }}" required oninvalid="this.setCustomValidity('Harap isi kolom ini.')" oninput="this.setCustomValidity('')">
                @error('title')
                    <span class="form-error-msg">{{ $message }}</span>
                @enderror
            </div>

            <!-- Summary / Excerpt Input -->
            <div class="mock-form-group">
                <label for="summary" class="mock-label">Ringkasan</label>
                <textarea name="summary" id="summary" class="mock-input mock-textarea" placeholder="Deskripsikan isi artikel dalam 1-2 kalimat...">{{ old('summary', $post->summary) }}</textarea>
                @error('summary')
                    <span class="form-error-msg">{{ $message }}</span>
                @enderror
            </div>

            <!-- Content Textarea -->
            <div class="mock-form-group">
                <label for="content" class="mock-label">Isi Artikel</label>
                <textarea name="content" id="content" class="mock-input mock-textarea mock-textarea-content" placeholder="Tulis isi artikel Anda di sini..." required oninvalid="this.setCustomValidity('Harap isi kolom ini.')" oninput="this.setCustomValidity('')">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <span class="form-error-msg">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image File/URL Upload Box -->
            <div class="mock-form-group">
                <label class="mock-label">Gambar Sampul</label>
                <div class="upload-box" onclick="document.getElementById('image-url-input').focus()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    <input type="url" name="image" id="image-url-input" class="mock-input" style="padding: 0; background: transparent; border-radius: 0; font-size: 0.95rem; color: var(--text-dark);" placeholder="Masukkan URL foto sampul artikel (https://...)" value="{{ old('image', $post->image) }}">
                </div>
                <span style="font-size: 0.75rem; color: var(--text-light-slate); margin-top: 0.15rem; margin-left: 0.5rem;">
                    Beri tautan gambar langsung. Jika dikosongkan, gambar default premium otomatis digunakan.
                </span>
                @error('image')
                    <span class="form-error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="mock-footer">
                <a href="{{ $backUrl }}" class="btn-mock-cancel">Batal</a>
                <button type="submit" class="btn-mock-submit">Simpan Perubahan</button>
            </div>

        </form>

    </div>
</div>

<script>
    // JS for category chip selection interaction
    document.querySelectorAll('.category-form-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            // Remove active class from all
            document.querySelectorAll('.category-form-chip').forEach(c => c.classList.remove('active'));
            // Add active class to clicked
            this.classList.add('active');
            // Set hidden field value
            document.getElementById('selected-category').value = this.getAttribute('data-value');
        });
    });

    // Make sure old selection is marked active on load
    window.addEventListener('DOMContentLoaded', () => {
        const selectedVal = document.getElementById('selected-category').value;
        if (selectedVal) {
            const activeChip = document.querySelector(`.category-form-chip[data-value="${selectedVal}"]`);
            if (activeChip) {
                activeChip.classList.add('active');
            }
        }
    });

    // Auto format tags with '#'
    const tagsInput = document.getElementById('tags');
    if (tagsInput) {
        function formatTags() {
            let val = tagsInput.value.trim();
            if (val === '') return;
            
            // Split by spaces or commas
            let words = val.split(/[\s,]+/);
            let formatted = words.map(word => {
                word = word.trim();
                if (word === '') return '';
                if (!word.startsWith('#')) {
                    return '#' + word;
                }
                return word;
            }).filter(w => w !== '').join(' ');
            
            tagsInput.value = formatted;
        }

        tagsInput.addEventListener('blur', formatTags);
        tagsInput.form.addEventListener('submit', formatTags);
    }
</script>
@endsection
