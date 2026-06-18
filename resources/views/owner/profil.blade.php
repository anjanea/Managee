@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Profil Saya')
@section('page_title', 'Profil Pemilik Properti')

@section('content')

<a href="{{ route('owner.dashboard') }}" class="back-link" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
    <span>Kembali ke Beranda</span>
</a>

<!-- Profile Update Alert -->
<div id="profile-alert-container"></div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; flex-wrap: wrap;">
    <!-- Profile Visual Card -->
    <div class="owner-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden; text-align: center; padding: 2rem;">
        <div style="width: 96px; height: 96px; background-color: var(--secondary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 2.5rem; margin: 0 auto 1rem auto; box-shadow: var(--shadow-md);">
            <span id="visual-avatar">{{ $profil['avatar'] }}</span>
        </div>
        <h3 id="visual-name" style="margin: 0 0 0.25rem 0; color: var(--primary);">{{ $profil['name'] }}</h3>
        <span class="owner-badge" style="background: var(--secondary); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">{{ $profil['member_since'] }}</span>
        
        <div style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem; text-align: left; display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 0.15rem;">Alamat Terdaftar</span>
                <span id="visual-address" style="font-size: 0.9rem; color: var(--text-main); font-weight: 500;">{{ $profil['address'] }}</span>
            </div>
            <div>
                <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 0.15rem;">Bio Singkat</span>
                <span id="visual-bio" style="font-size: 0.85rem; color: var(--text-muted); font-style: italic; line-height: 1.4;">"{{ $profil['bio'] }}"</span>
            </div>
        </div>
    </div>

    <!-- Edit Profil Form -->
    <div class="owner-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
        <div class="card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--border);">
            <h4 style="margin: 0; color: var(--primary);">Pengaturan Informasi Profil</h4>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <label for="profil-name" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Nama Lengkap</label>
                    <input type="text" id="profil-name" value="{{ $profil['name'] }}" style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.95rem; outline: none;">
                </div>
                <div>
                    <label for="profil-phone" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Nomor Telepon</label>
                    <input type="text" id="profil-phone" value="{{ $profil['phone'] }}" style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.95rem; outline: none;">
                </div>
            </div>
            
            <div style="margin-bottom: 1.25rem;">
                <label for="profil-email" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Alamat Surel</label>
                <input type="email" id="profil-email" value="{{ $profil['email'] }}" style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.95rem; outline: none;">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label for="profil-address" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Alamat Rumah / Kantor</label>
                <input type="text" id="profil-address" value="{{ $profil['address'] }}" style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.95rem; outline: none;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="profil-bio" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Biografi Singkat</label>
                <textarea id="profil-bio" rows="4" style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 0.95rem; outline: none; resize: vertical;">{{ $profil['bio'] }}</textarea>
            </div>

            <button onclick="saveProfile()" class="btn" style="background: var(--secondary); color: white; border: none; padding: 0.75rem 1.5rem; font-weight: 600; font-size: 0.95rem; border-radius: var(--radius-md); cursor: pointer; transition: var(--transition); box-shadow: var(--shadow-sm);">Simpan Perubahan</button>
        </div>
    </div>
</div>

<script>
    function saveProfile() {
        const name = document.getElementById('profil-name').value;
        const phone = document.getElementById('profil-phone').value;
        const email = document.getElementById('profil-email').value;
        const address = document.getElementById('profil-address').value;
        const bio = document.getElementById('profil-bio').value;

        if (!name || !email) {
            alert('Nama Lengkap dan Surel wajib diisi!');
            return;
        }

        // Update visual elements
        document.getElementById('visual-name').textContent = name;
        document.getElementById('visual-avatar').textContent = name.charAt(0).toUpperCase();
        document.getElementById('visual-address').textContent = address;
        document.getElementById('visual-bio').textContent = `"${bio}"`;

        // Success Alert
        const container = document.getElementById('profile-alert-container');
        const alertDiv = document.createElement('div');
        alertDiv.className = 'owner-alert owner-alert-success';
        alertDiv.style.marginBottom = '1.5rem';
        alertDiv.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg>
            <span>Informasi profil Anda berhasil diperbarui!</span>
        `;
        container.innerHTML = '';
        container.appendChild(alertDiv);
        
        // Update profile name in topbar header dynamically
        const topbarName = document.querySelector('.profile-name');
        const topbarAvatar = document.querySelector('.profile-avatar span');
        if (topbarName) topbarName.textContent = name;
        if (topbarAvatar) topbarAvatar.textContent = name.charAt(0).toUpperCase();

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>

@endsection
