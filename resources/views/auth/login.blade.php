@extends('layouts.app')

@section('title', 'Managee - Masuk')

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

    /* Role Switcher Tabs */
    .role-switcher {
        display: flex;
        background-color: var(--bg-light-gray);
        border: 1px solid var(--border-color);
        border-radius: 9999px;
        padding: 4px;
        margin-bottom: 2rem;
    }

    .role-tab {
        flex: 1;
        padding: 0.6rem 1rem;
        text-align: center;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-slate);
        border-radius: 9999px;
        cursor: pointer;
        transition: all 0.25s ease;
        border: none;
        background: none;
        outline: none;
    }

    .role-tab.active {
        background-color: var(--emerald-primary);
        color: #FFFFFF;
        box-shadow: 0 2px 8px rgba(26, 60, 52, 0.15);
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

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        margin-bottom: 1.75rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        color: var(--text-slate);
        cursor: pointer;
    }

    .remember-me input {
        accent-color: var(--emerald-light);
        cursor: pointer;
    }

    .forgot-link {
        color: var(--emerald-light);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .forgot-link:hover {
        color: var(--emerald-primary);
        text-decoration: underline;
    }

    .btn-auth-submit {
        width: 100%;
        background-color: var(--secondary-gold);
        color: #FFFFFF;
        border: none;
        padding: 0.9rem 2rem;
        font-family: inherit;
        font-size: 1.05rem;
        font-weight: 700;
        border-radius: 9999px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(202, 138, 4, 0.2);
    }

    .btn-auth-submit:hover {
        background-color: var(--secondary-gold-light);
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

    .alert-danger-container {
        background-color: #FFF5F5;
        border: 1px solid #FEB2B2;
        color: #E53E3E;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
</style>

<div class="auth-page-container">
    <div class="auth-card">
        
        <div class="auth-header">
            <h1 class="auth-title">Selamat Datang</h1>
            <p class="auth-subtitle">Masuk ke akun Managee Anda</p>
        </div>

        @if($errors->has('role_error'))
            <div class="alert-danger-container">
                {{ $errors->first('role_error') }}
            </div>
        @endif

        <!-- Role Switcher -->
        <div class="role-switcher">
            <button type="button" class="role-tab {{ old('role', 'user') === 'user' ? 'active' : '' }}" onclick="setRole('user', this)">
                Penyewa
            </button>
            <button type="button" class="role-tab {{ old('role') === 'owner' ? 'active' : '' }}" onclick="setRole('owner', this)">
                Pemilik
            </button>
        </div>

        <!-- Login Form -->
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <!-- Hidden Role Input -->
            <input type="hidden" name="role" id="role-input" value="{{ old('role', 'user') }}">

            <div class="form-group">
                <label for="email">Alamat Surel <span style="color: #E53E3E;">*</span></label>
                <input type="email" name="email" id="email" class="form-input" placeholder="surel@contoh.com" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi <span style="color: #E53E3E;">*</span></label>
                <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ingat Saya</span>
                </label>
                <a href="{{ route('password.request') }}" class="forgot-link">Lupa Kata Sandi?</a>
            </div>

            <button type="submit" class="btn-auth-submit">
                Masuk
            </button>
        </form>

        <div class="auth-footer" id="register-footer-container" style="{{ old('role', 'user') === 'owner' ? 'display: none;' : '' }}">
            Belum memiliki akun? <a href="/register">Daftar Sekarang</a>
        </div>

    </div>
</div>

<script>
    function setRole(role, element) {
        // Update hidden input
        document.getElementById('role-input').value = role;

        // Toggle active tabs
        document.querySelectorAll('.role-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        element.classList.add('active');

        // Toggle register footer link visibility (since owners can't register)
        const registerFooter = document.getElementById('register-footer-container');
        if (role === 'owner') {
            registerFooter.style.display = 'none';
        } else {
            registerFooter.style.display = 'block';
        }
    }
</script>
@endsection
