<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Managee')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    <!-- Header / Navbar -->
    <header class="navbar">
        <div class="container navbar-container">
            <!-- Logo -->
            <a href="/" class="logo">
                <img src="{{ asset('logo.png') }}" alt="Managee Logo">
                <span>Managee</span>
            </a>

            <!-- Nav Links -->
            <nav class="nav-links">
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                <a href="/properti" class="{{ request()->is('properti*') ? 'active' : '' }}">Properti</a>
                <a href="{{ route('about') }}" class="{{ request()->is('tentang-kami*') ? 'active' : '' }}">Tentang Kami</a>
                <a href="{{ route('blog.public') }}" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a>
            </nav>

            <!-- Actions -->
            <div class="nav-actions" style="display: flex; align-items: center; gap: 1.25rem;">
                @auth
                    @if(auth()->user()->role === 'owner')
                        <a href="/owner/dashboard" class="btn-nav-link" style="font-weight: 700; color: var(--primary);">Dashboard Pemilik</a>
                    @else
                        <a href="/login" class="btn-nav-link">Daftarkan Properti</a>
                    @endif
                    
                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown-wrapper">
                        <button class="profile-dropdown-trigger" onclick="toggleProfileDropdown(event)">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background-color: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span>{{ auth()->user()->name }}</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left: 2px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="profileDropdown" class="profile-dropdown-menu">
                            @if(auth()->user()->role === 'owner')
                                <a href="{{ route('owner.profil.index') }}" class="profile-dropdown-item">
                                    👤 Profil Pemilik
                                </a>
                                <a href="{{ route('owner.bookings.index') }}" class="profile-dropdown-item">
                                    📅 Kelola Pemesanan
                                </a>
                                <a href="{{ route('owner.blog.index') }}" class="profile-dropdown-item">
                                    ✍️ Kelola Artikel
                                </a>
                                <a href="{{ route('owner.bantuan.index') }}" class="profile-dropdown-item">
                                    ❓ Pusat Bantuan (FAQ)
                                </a>
                            @else
                                <a href="{{ route('user.profile.show') }}" class="profile-dropdown-item">
                                    👤 Profil Saya
                                </a>
                                <a href="{{ route('user.bookings.index') }}" class="profile-dropdown-item">
                                    📅 Pesanan Saya
                                </a>
                                <a href="{{ route('blog.my_posts_public') }}" class="profile-dropdown-item">
                                    ✍️ Artikel Saya
                                </a>
                                <a href="{{ route('user.help') }}" class="profile-dropdown-item">
                                    ❓ Pusat Bantuan
                                </a>
                            @endif
                            <div class="profile-dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="profile-dropdown-item logout-btn">
                                    🚪 Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login" class="btn-nav-link">Daftarkan Properti</a>
                    <a href="/login" class="btn-login">Masuk/Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-container">
            <div class="footer-brand">
                <a href="/" class="logo logo-light">
                    <img src="{{ asset('logo.png') }}" alt="Managee Logo">
                    <span>Managee</span>
                </a>
                <p>Platform terpercaya untuk penyewaan properti dan penginapan harian di Indonesia</p>
                <div class="footer-socials">
                    <a href="#" class="social-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="#" class="social-icon">
                        <!-- Twitter / X Icon representation -->
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                    </a>
                </div>
            </div>
            <div class="footer-links">
                <h4>Jelajahi</h4>
                <a href="/">Beranda</a>
                <a href="/properti">Cari Properti</a>
                <a href="{{ route('blog.public') }}">Blog & Panduan</a>
                <a href="{{ route('about') }}">Tentang Kami</a>
            </div>
            <div class="footer-links">
                <h4>Untuk Pemilik</h4>
                <a href="{{ auth()->check() && auth()->user()->role === 'owner' ? route('owner.properties.create') : route('login') }}">Daftarkan Properti</a>
                <a href="{{ auth()->check() && auth()->user()->role === 'owner' ? route('owner.bantuan.index') : route('login') }}">Panduan Pemilik</a>
                <a href="{{ route('blog.public') }}">Panduan & Trik</a>
                <a href="{{ route('about') }}">Kemitraan</a>
            </div>
            <div class="footer-links">
                <h4>Hubungi Kami</h4>
                <div class="footer-contact-item">
                    <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <span>Jl. Sunset Road No. 88, Seminyak, Badung, Bali, Indonesia</span>
                </div>
                <div class="footer-contact-item">
                    <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <span>+62 361 8899 7766</span>
                </div>
                <div class="footer-contact-item">
                    <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <span>info@managee.id</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Managee. Semua hak dilindungi.</p>
            <div class="footer-bottom-links">
                <a href="javascript:void(0)" onclick="alert('Kebijakan Privasi sedang diperbarui oleh Tim Hukum Managee. Hubungi info@managee.id untuk informasi lebih lanjut.')">Kebijakan Privasi</a>
                <a href="javascript:void(0)" onclick="alert('Syarat & Ketentuan saat ini sedang disesuaikan. Hubungi info@managee.id untuk berkas salinan terbaru.')">Syarat & Ketentuan</a>
                <a href="{{ auth()->check() ? (auth()->user()->role === 'owner' ? route('owner.bantuan.index') : route('user.help')) : route('login') }}">Bantuan</a>
            </div>
            <button class="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                <svg class="progress-ring" width="56" height="56">
                    <circle class="progress-ring__circle-track" stroke="rgba(202, 138, 4, 0.15)" stroke-width="3.5" fill="transparent" r="24" cx="28" cy="28"/>
                    <circle class="progress-ring__circle-bar" stroke="var(--secondary)" stroke-width="3.5" fill="transparent" r="24" cx="28" cy="28" stroke-dasharray="150.8" stroke-dashoffset="150.8"/>
                </svg>
                <svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
            </button>
        </div>
    </footer>

    <script>
        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });

        // Tampilkan/sembunyikan tombol back-to-top & update progress ring berdasarkan scroll
        window.addEventListener('scroll', function() {
            const backToTopBtn = document.querySelector('.back-to-top');
            if (backToTopBtn) {
                const circleBar = document.querySelector('.progress-ring__circle-bar');
                const scrollPercent = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight);
                
                // Keliling lingkaran r=24 adalah 2 * Math.PI * 24 = 150.8
                const circumference = 2 * Math.PI * 24; 
                if (circleBar) {
                    const offset = circumference - (scrollPercent * circumference);
                    circleBar.style.strokeDashoffset = Math.max(0, Math.min(circumference, offset));
                }

                if (window.scrollY > 300) {
                    backToTopBtn.style.display = 'flex';
                } else {
                    backToTopBtn.style.display = 'none';
                }
            }
        });

        // Translate HTML5 validation messages to Indonesian globally
        document.addEventListener('DOMContentLoaded', function() {
            function translateValidation(el) {
                if (!el) return;
                
                const updateValidity = () => {
                    el.setCustomValidity(''); // Reset first
                    if (!el.validity.valid) {
                        if (el.validity.valueMissing) {
                            el.setCustomValidity('Harap isi kolom ini.');
                        } else if (el.validity.typeMismatch) {
                            if (el.type === 'email') {
                                el.setCustomValidity('Harap masukkan alamat email yang valid dengan menyertakan \'@\'.');
                            } else if (el.type === 'url') {
                                el.setCustomValidity('Harap masukkan URL yang valid.');
                            }
                        } else if (el.validity.badInput) {
                            el.setCustomValidity('Harap masukkan nilai yang valid.');
                        } else if (el.validity.patternMismatch) {
                            el.setCustomValidity('Harap sesuaikan dengan format yang diminta.');
                        } else if (el.validity.rangeOverflow) {
                            el.setCustomValidity('Nilai harus kurang dari atau sama dengan ' + el.max + '.');
                        } else if (el.validity.rangeUnderflow) {
                            el.setCustomValidity('Nilai harus lebih besar dari atau sama dengan ' + el.min + '.');
                        } else if (el.validity.tooShort) {
                            el.setCustomValidity('Harap perpanjang teks ini menjadi ' + el.minLength + ' karakter atau lebih.');
                        } else if (el.validity.tooLong) {
                            el.setCustomValidity('Harap perpendek teks ini menjadi ' + el.maxLength + ' karakter atau kurang.');
                        } else if (el.validity.stepMismatch) {
                            el.setCustomValidity('Harap masukkan nilai yang valid.');
                        }
                    }
                };

                el.addEventListener('input', updateValidity);
                el.addEventListener('change', updateValidity);
                el.addEventListener('invalid', updateValidity);
                
                updateValidity();
            }

            function applyToPage() {
                document.querySelectorAll('input, textarea, select').forEach(el => {
                    if (!el.dataset.translated) {
                        translateValidation(el);
                        el.dataset.translated = 'true';
                    }
                });
            }

            applyToPage();

            // Observe dynamic additions
            const observer = new MutationObserver(applyToPage);
            observer.observe(document.body, { childList: true, subtree: true });
        });
    </script>
</body>
</html>
