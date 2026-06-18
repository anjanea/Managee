@extends('layouts.app')

@section('title', 'Managee - Daftar')

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

    .auth-page-container {
        padding-top: 120px;
        padding-bottom: 5rem;
        background-color: var(--bg-light-gray);
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
    }

    .auth-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        width: 100%;
        max-width: 450px;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--emerald-primary);
        margin: 0 0 0.5rem 0;
    }

    .auth-subtitle {
        font-size: 0.9rem;
        color: var(--text-light-slate);
        margin: 0;
    }

    /* Form Styles */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-bottom: 1.25rem;
    }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .form-input {
        width: 100%;
        padding: 0.8rem 1.5rem;
        font-family: inherit;
        font-size: 0.95rem;
        color: var(--text-dark);
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 9999px;
        outline: none;
        transition: all 0.25s ease;
    }

    .form-input:focus {
        border-color: var(--emerald-light);
        box-shadow: 0 0 0 3px var(--emerald-glow);
    }

    .form-error {
        font-size: 0.8rem;
        color: #E53E3E;
        font-weight: 600;
        margin-top: 0.25rem;
        margin-left: 0.5rem;
    }

    .btn-auth-submit {
        width: 100%;
        background-color: var(--emerald-primary);
        color: #FFFFFF;
        border: none;
        padding: 0.9rem 2rem;
        font-family: inherit;
        font-size: 1.05rem;
        font-weight: 700;
        border-radius: 9999px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(26, 60, 52, 0.15);
        margin-top: 1rem;
    }

    .btn-auth-submit:hover {
        background-color: var(--emerald-light);
        transform: translateY(-1px);
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        font-size: 0.9rem;
        color: var(--text-slate);
    }

    .auth-footer a {
        color: var(--emerald-light);
        text-decoration: none;
        font-weight: 700;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }
</style>

<div class="auth-page-container">
    <div class="auth-card">
        
        <div class="auth-header">
            <h1 class="auth-title">Daftar Akun</h1>
            <p class="auth-subtitle">Daftar di Managee untuk sewa properti impian anda</p>
        </div>

        <!-- Register Form -->
        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap <span style="color: #E53E3E;">*</span></label>
                <input type="text" name="name" id="name" class="form-input" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Surel <span style="color: #E53E3E;">*</span></label>
                <input type="email" name="email" id="email" class="form-input" placeholder="surel@contoh.com" value="{{ old('email') }}" required oninvalid="this.setCustomValidity(this.validity.typeMismatch ? 'Harap masukkan alamat surel yang valid dengan menyertakan \'@\'.' : (this.validity.valueMissing ? 'Alamat surel wajib diisi.' : ''))" oninput="this.setCustomValidity('')">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi <span style="color: #E53E3E;">*</span></label>
                <input type="password" name="password" id="password" class="form-input" placeholder="Minimal 8 karakter" required>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi <span style="color: #E53E3E;">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Masukkan kembali kata sandi" required>
            </div>

            <button type="submit" class="btn-auth-submit">
                Daftar
            </button>
        </form>

        <div class="auth-footer">
            Sudah memiliki akun? <a href="/login">Masuk disini</a>
        </div>

    </div>
</div>
@endsection
