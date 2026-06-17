<!DOCTYPE html>
<html lang="id">
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
    
    <style>
        .profile-dropdown-menu a.dropdown-item:hover {
            background-color: var(--bg-light);
        }
        .profile-dropdown-menu a.dropdown-item.logout-item:hover {
            background-color: #fee2e2 !important;
            color: #ef4444 !important;
        }
    </style>
</head>
<body class="owner-dashboard-body">

    <!-- Sidebar -->
    <aside class="owner-sidebar">
        <div class="owner-sidebar-header">
            <a href="{{ route('owner.dashboard') }}" class="logo logo-light">
                <img src="{{ asset('logo.png') }}" alt="Managee Logo">
                <span>Managee</span>
            </a>
            <span class="owner-badge">PEMILIK</span>
        </div>

        <nav class="owner-sidebar-nav">
            <a href="{{ route('owner.dashboard') }}" class="sidebar-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                <span>Beranda</span>
            </a>
            <a href="{{ route('owner.properties.index') }}" class="sidebar-item {{ request()->routeIs('owner.properties.*') || request()->routeIs('owner.promo.index') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>Properti Saya</span>
            </a>
            <a href="{{ route('owner.bookings.index') }}" class="sidebar-item {{ request()->routeIs('owner.bookings.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>Pemesanan</span>
            </a>
            <a href="{{ route('owner.keuangan.index') }}" class="sidebar-item {{ request()->routeIs('owner.keuangan.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2" ry="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                <span>Keuangan</span>
            </a>
            <a href="{{ route('owner.blog.index') }}" class="sidebar-item {{ request()->routeIs('owner.blog.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <span>Blog Artikel</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="owner-main-container">
        
        <!-- Topbar -->
        <header class="owner-topbar">
            <div class="topbar-title">
                <h2>@yield('page_title', 'Ringkasan')</h2>
                @yield('page_subtitle')
            </div>

            <div class="topbar-profile">
                <!-- Notification Bell Container -->
                <div class="notification-container" style="position: relative; margin-right: 0.5rem;">
                    <button type="button" id="notification-bell" style="background: none; border: none; cursor: pointer; color: var(--text-muted); position: relative; padding: 0.25rem; display: flex; align-items: center; justify-content: center; outline: none; transition: var(--transition);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span id="notification-badge" style="position: absolute; top: 0; right: 0; width: 8px; height: 8px; background-color: #ef4444; border-radius: 50%; border: 2px solid white;"></span>
                    </button>
                    <!-- Dropdown List -->
                    <div id="notification-dropdown" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 0.75rem; width: 280px; background: white; border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-lg); z-index: 1000; padding: 0.75rem 0;">
                        <div style="font-weight: 700; font-size: 0.85rem; color: var(--primary); padding: 0.25rem 1rem 0.5rem 1rem; border-bottom: 1px solid var(--border); margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
                            <span>Pemberitahuan</span>
                            <span style="font-size: 0.75rem; font-weight: 500; color: var(--text-muted);">1 Baru</span>
                        </div>
                        <a href="{{ route('owner.dashboard') }}" class="notification-item" style="display: flex; gap: 0.75rem; padding: 0.75rem 1rem; text-decoration: none; border-bottom: 1px solid #f8fafc; align-items: flex-start; transition: var(--transition);">
                            <div style="background: rgba(202, 138, 4, 0.1); color: var(--secondary); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.15rem;">
                                <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); line-height: 1.2;">Pemesanan Baru</span>
                                <span style="font-size: 0.75rem; color: var(--text-muted); line-height: 1.3;">Clara Amalia menunggu persetujuan sewa Villa Canggu.</span>
                                <span style="font-size: 0.7rem; color: var(--text-muted); margin-top: 0.15rem;">Baru Saja</span>
                            </div>
                        </a>
                        <div style="text-align: center; padding: 0.5rem 0.5rem 0 0.5rem;">
                            <a href="#" style="font-size: 0.8rem; font-weight: 600; color: var(--secondary); text-decoration: none;">Lihat semua pemberitahuan</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown Container -->
                <div class="profile-container" style="position: relative;">
                    <button type="button" id="profile-menu-button" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; text-align: left; padding: 0.25rem; outline: none;">
                        <div class="profile-info" style="display: flex; flex-direction: column; text-align: right;">
                            <span class="profile-name" style="font-weight: 600; color: var(--text-main); font-size: 0.95rem;">Anjani</span>
                            <span class="profile-role" style="font-size: 0.8rem; color: var(--text-muted);">Mitra Pemilik</span>
                        </div>
                        <div class="profile-avatar" style="width: 40px; height: 40px; background-color: var(--secondary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem;">
                            <span>A</span>
                        </div>
                    </button>
                    <!-- Dropdown List -->
                    <div id="profile-dropdown" class="profile-dropdown-menu" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 0.75rem; width: 200px; background: white; border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-lg); z-index: 1000; padding: 0.5rem 0;">
                        <a href="{{ route('owner.profil.index') }}" class="dropdown-item" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; font-size: 0.85rem; color: var(--text-main); text-decoration: none; transition: var(--transition);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ route('owner.ulasan.index') }}" class="dropdown-item" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; font-size: 0.85rem; color: var(--text-main); text-decoration: none; transition: var(--transition);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <span>Ulasan Properti</span>
                        </a>
                        <a href="{{ route('owner.bantuan.index') }}" class="dropdown-item" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; font-size: 0.85rem; color: var(--text-main); text-decoration: none; transition: var(--transition);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                            <span>Pusat Bantuan (FAQ)</span>
                        </a>
                        <div style="height: 1px; background: var(--border); margin: 0.4rem 0;"></div>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
                            @csrf
                            <button type="submit" class="dropdown-item logout-item" style="width: 100%; border: none; background: none; text-align: left; display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; font-size: 0.85rem; color: #ef4444; cursor: pointer; transition: var(--transition); font-family: inherit;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="owner-content-wrapper">
            @yield('content')
        </main>
        
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const bell = document.getElementById('notification-bell');
        const notifDropdown = document.getElementById('notification-dropdown');
        
        const profileBtn = document.getElementById('profile-menu-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        if (bell && notifDropdown) {
            bell.addEventListener('click', function(e) {
                e.stopPropagation();
                if (profileDropdown) profileDropdown.style.display = 'none';
                const isHidden = notifDropdown.style.display === 'none';
                notifDropdown.style.display = isHidden ? 'block' : 'none';
                bell.style.color = isHidden ? 'var(--primary)' : 'var(--text-muted)';
            });
        }

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (notifDropdown) {
                    notifDropdown.style.display = 'none';
                    bell.style.color = 'var(--text-muted)';
                }
                const isHidden = profileDropdown.style.display === 'none';
                profileDropdown.style.display = isHidden ? 'block' : 'none';
            });
        }

        document.addEventListener('click', function(e) {
            if (bell && notifDropdown && !bell.contains(e.target) && !notifDropdown.contains(e.target)) {
                notifDropdown.style.display = 'none';
                bell.style.color = 'var(--text-muted)';
            }
            if (profileBtn && profileDropdown && !profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.style.display = 'none';
            }
        });

        // Translate HTML5 validation messages to Indonesian globally
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
