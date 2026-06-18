@extends('layouts.app')

@section('title', 'Managee - Profil Saya')

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

    .profile-page-container {
        padding-top: 120px;
        padding-bottom: 5rem;
        background-color: var(--bg-light-gray);
        font-family: 'Outfit', sans-serif;
        min-height: 85vh;
    }

    .profile-card {
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.02);
        max-width: 680px;
        margin: 0 auto;
        overflow: hidden;
    }

    .profile-header-accent {
        height: 120px;
        background: linear-gradient(135deg, var(--emerald-primary), var(--emerald-light));
    }

    .profile-avatar-row {
        padding: 0 2.5rem;
        margin-top: 0;
        display: flex;
        align-items: flex-end;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .profile-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: var(--secondary-gold);
        color: #FFFFFF;
        border: 4px solid #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 800;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        text-transform: uppercase;
        margin-top: -50px;
    }

    .profile-user-summary {
        margin-bottom: 10px;
    }

    .profile-user-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--emerald-primary);
        margin: 0;
    }

    .profile-user-role {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--emerald-light);
        text-transform: uppercase;
        background-color: var(--emerald-glow);
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
        display: inline-block;
        margin-top: 0.25rem;
    }

    .profile-body {
        padding: 0 2.5rem 2.5rem 2.5rem;
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--emerald-primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    /* Form Styles */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .form-group-full {
        grid-column: span 2;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .form-input {
        width: 100%;
        padding: 0.8rem 1.25rem;
        font-family: inherit;
        font-size: 0.95rem;
        color: var(--text-dark);
        background-color: var(--bg-light-gray);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        outline: none;
        transition: all 0.25s ease;
    }

    .form-input:focus {
        border-color: var(--emerald-light);
        background-color: #FFFFFF;
        box-shadow: 0 0 0 3px var(--emerald-glow);
    }

    .btn-save-profile {
        background-color: var(--emerald-primary);
        color: #FFFFFF;
        padding: 0.85rem 2rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 15px rgba(26, 60, 52, 0.15);
    }

    .btn-save-profile:hover {
        background-color: var(--emerald-light);
        transform: translateY(-1px);
    }

    @media (max-width: 600px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group-full {
            grid-column: span 1;
        }
        .profile-avatar-row {
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: 0;
        }
        .profile-avatar-row .profile-avatar-large {
            margin-top: -60px;
        }
        .profile-body {
            padding: 0 1.5rem 1.5rem 1.5rem;
        }
    }
</style>

<div class="profile-page-container">
    <div class="container">
        
        <!-- Back Button -->
        <div style="max-width: 680px; margin: 0 auto 1.5rem auto;">
            <a href="/" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-light-slate); font-size: 0.95rem; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.color='var(--emerald-primary)'" onmouseout="this.style.color='var(--text-light-slate)'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
        
        <!-- Alerts for feedback -->
        @if(session('success'))
            <div style="background-color: #DEF7EC; border: 1px solid #BCF0DA; color: #03543F; padding: 1rem 1.5rem; border-radius: 12px; max-width: 680px; margin: 0 auto 2rem auto; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif



        <div class="profile-card">
            <!-- Accent banner header -->
            <div class="profile-header-accent"></div>

            <!-- Avatar & Name row -->
            <div class="profile-avatar-row">
                <div class="profile-avatar-large">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="profile-user-summary">
                    <h2 class="profile-user-name">{{ $user->name }}</h2>
                    <span class="profile-user-role">
                        {{ $user->role === 'owner' ? 'Pemilik Properti' : 'Penyewa' }}
                    </span>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="profile-body">
                <form action="{{ route('user.profile.update') }}" method="POST" id="profile-form">
                    @csrf
                    
                    <h3 class="section-title">Informasi Pribadi</h3>
                    <div class="form-grid">
                        <!-- Nama Lengkap -->
                        <div class="form-group form-group-full">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" placeholder="Contoh: Budi Santoso" required>
                            <span id="js-error-name" class="form-error" style="color: #E53E3E; font-size: 0.8rem; font-weight: 600; margin-top: 0.25rem; margin-left: 0.25rem; display: none;"></span>
                            @error('name')
                                <span class="form-error server-error" style="color: #E53E3E; font-size: 0.8rem; font-weight: 600; margin-top: 0.25rem; margin-left: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Alamat Surel</label>
                            <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" placeholder="budi@surel.com" required
                                   oninvalid="this.setCustomValidity(this.validity.typeMismatch ? 'Harap masukkan alamat surel yang valid dengan menyertakan \'@\'.' : (this.validity.valueMissing ? 'Alamat surel wajib diisi.' : ''))" 
                                   oninput="this.setCustomValidity('')">
                            <span id="js-error-email" class="form-error" style="color: #E53E3E; font-size: 0.8rem; font-weight: 600; margin-top: 0.25rem; margin-left: 0.25rem; display: none;"></span>
                            @error('email')
                                <span class="form-error server-error" style="color: #E53E3E; font-size: 0.8rem; font-weight: 600; margin-top: 0.25rem; margin-left: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890">
                            <span id="js-error-phone" class="form-error" style="color: #E53E3E; font-size: 0.8rem; font-weight: 600; margin-top: 0.25rem; margin-left: 0.25rem; display: none;"></span>
                            @error('phone')
                                <span class="form-error server-error" style="color: #E53E3E; font-size: 0.8rem; font-weight: 600; margin-top: 0.25rem; margin-left: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h3 class="section-title">Keamanan & Sandi Baru</h3>
                    <div class="form-grid" style="margin-bottom: 2.5rem;">
                        <!-- Sandi baru -->
                        <div class="form-group">
                            <label for="password">Kata Sandi Baru</label>
                            <input type="password" id="password" name="password" class="form-input" placeholder="Isi hanya jika ingin mengubah">
                            <span id="js-error-password" class="form-error" style="color: #E53E3E; font-size: 0.8rem; font-weight: 600; margin-top: 0.25rem; margin-left: 0.25rem; display: none;"></span>
                            @error('password')
                                <span class="form-error server-error" style="color: #E53E3E; font-size: 0.8rem; font-weight: 600; margin-top: 0.25rem; margin-left: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Konfirmasi Sandi baru -->
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi kata sandi baru">
                            <span id="js-error-password_confirmation" class="form-error" style="color: #E53E3E; font-size: 0.8rem; font-weight: 600; margin-top: 0.25rem; margin-left: 0.25rem; display: none;"></span>
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <button type="submit" class="btn-save-profile">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('profile-form');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');

        // Spans
        const errName = document.getElementById('js-error-name');
        const errEmail = document.getElementById('js-error-email');
        const errPhone = document.getElementById('js-error-phone');
        const errPassword = document.getElementById('js-error-password');
        const errConfirm = document.getElementById('js-error-password_confirmation');

        function clearServerErrors() {
            document.querySelectorAll('.server-error').forEach(el => el.style.display = 'none');
        }

        // Live Validation on input / keyup
        nameInput.addEventListener('input', function() {
            clearServerErrors();
            if (nameInput.value.trim() === '') {
                errName.textContent = 'Nama lengkap wajib diisi.';
                errName.style.display = 'block';
            } else {
                errName.style.display = 'none';
            }
        });

        emailInput.addEventListener('input', function() {
            clearServerErrors();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() === '') {
                errEmail.textContent = 'Alamat surel wajib diisi.';
                errEmail.style.display = 'block';
            } else if (!emailRegex.test(emailInput.value.trim())) {
                errEmail.textContent = 'Format surel tidak valid.';
                errEmail.style.display = 'block';
            } else {
                errEmail.style.display = 'none';
            }
        });

        passwordInput.addEventListener('input', function() {
            clearServerErrors();
            const val = passwordInput.value;
            if (val.length > 0 && val.length < 8) {
                errPassword.textContent = 'Kata sandi baru minimal harus 8 karakter.';
                errPassword.style.display = 'block';
            } else {
                errPassword.style.display = 'none';
            }

            // Also check confirmation matching if it has value
            if (passwordConfirmInput.value.length > 0) {
                if (val !== passwordConfirmInput.value) {
                    errConfirm.textContent = 'Konfirmasi kata sandi baru tidak cocok.';
                    errConfirm.style.display = 'block';
                } else {
                    errConfirm.style.display = 'none';
                }
            }
        });

        passwordConfirmInput.addEventListener('input', function() {
            clearServerErrors();
            if (passwordInput.value !== passwordConfirmInput.value) {
                errConfirm.textContent = 'Konfirmasi kata sandi baru tidak cocok.';
                errConfirm.style.display = 'block';
            } else {
                errConfirm.style.display = 'none';
            }
        });

        // Form Submit interception
        form.addEventListener('submit', function(e) {
            clearServerErrors();
            let hasError = false;

            // Validate Name
            if (nameInput.value.trim() === '') {
                errName.textContent = 'Nama lengkap wajib diisi.';
                errName.style.display = 'block';
                hasError = true;
            }

            // Validate Email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() === '') {
                errEmail.textContent = 'Alamat surel wajib diisi.';
                errEmail.style.display = 'block';
                hasError = true;
            } else if (!emailRegex.test(emailInput.value.trim())) {
                errEmail.textContent = 'Format surel tidak valid.';
                errEmail.style.display = 'block';
                hasError = true;
            }

            // Validate Password
            const pwdVal = passwordInput.value;
            if (pwdVal.length > 0) {
                if (pwdVal.length < 8) {
                    errPassword.textContent = 'Kata sandi baru minimal harus 8 karakter.';
                    errPassword.style.display = 'block';
                    hasError = true;
                }

                if (pwdVal !== passwordConfirmInput.value) {
                    errConfirm.textContent = 'Konfirmasi kata sandi baru tidak cocok.';
                    errConfirm.style.display = 'block';
                    hasError = true;
                }
            }

            if (hasError) {
                e.preventDefault(); // Stop form submission
                // Scroll to the first error
                const firstError = document.querySelector('.form-error[style*="display: block"]');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    });
</script>
@endsection
