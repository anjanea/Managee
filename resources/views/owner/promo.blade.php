@extends('layouts.owner')

@section('title', 'Managee Owner Dashboard - Manajemen Promo')
@section('page_title', 'Manajemen Promo & Diskon')

@section('content')

<!-- Header Action Row -->
<div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 2rem; box-shadow: var(--shadow-sm); display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap;">
    <div>
        <h4 style="margin: 0 0 0.25rem 0; color: var(--primary);">Strategi Pemasaran Villa & Properti</h4>
        <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">Buat promo menarik untuk meningkatkan okupansi properti Anda di musim sepi (low-season).</p>
    </div>
    <button onclick="openPromoModal()" class="btn" style="background: var(--secondary); color: white; border: none; padding: 0.75rem 1.5rem; font-weight: 600; font-size: 0.95rem; border-radius: var(--radius-md); cursor: pointer; transition: var(--transition); display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: var(--shadow-sm);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        <span>Buat Promo Baru</span>
    </button>
</div>

<!-- Promo List Card -->
<div class="owner-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
    <div class="card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <h4 style="margin: 0; color: var(--primary);">Daftar Promo Aktif & Riwayat</h4>
        <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">
            Total: <span id="promo-count" style="font-weight: 700; color: var(--secondary);">{{ count($promos) }}</span> Promo
        </div>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <div class="table-responsive">
            <table class="owner-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border); font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted);">
                        <th style="padding: 0.75rem 0;">Kode Promo</th>
                        <th>Diskon</th>
                        <th>Properti Sasaran</th>
                        <th>Masa Berlaku</th>
                        <th>Digunakan</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="promo-tbody">
                    @foreach($promos as $promo)
                    <tr class="promo-row" id="promo-row-{{ $promo['id'] }}" style="border-bottom: 1px solid var(--border); font-size: 0.95rem; transition: var(--transition);">
                        <td style="padding: 1rem 0;">
                            <code style="font-family: monospace; background: var(--bg-light); border: 1px dashed var(--border); padding: 0.35rem 0.65rem; border-radius: 4px; font-weight: 700; color: var(--primary); font-size: 0.95rem;">
                                {{ $promo['code'] }}
                            </code>
                        </td>
                        <td style="font-weight: 700; color: #22c55e;">{{ $promo['discount_percent'] }}% Diskon</td>
                        <td style="font-weight: 500; color: var(--text-main);">{{ $promo['target_property'] }}</td>
                        <td style="color: var(--text-muted); font-size: 0.9rem;">
                            {{ $promo['start_date'] }} - {{ $promo['end_date'] }}
                        </td>
                        <td style="font-weight: 600; color: var(--text-main);">
                            {{ $promo['used_count'] }}x terpakai
                        </td>
                        <td>
                            <span class="status-badge" style="font-weight: 600; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 4px;
                                background: {{ $promo['status'] == 'Aktif' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)' }};
                                color: {{ $promo['status'] == 'Aktif' ? '#22c55e' : '#ef4444' }};">
                                {{ $promo['status'] }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            @if($promo['status'] == 'Aktif')
                            <button onclick="deactivatePromo({{ $promo['id'] }})" class="btn-deactivate" style="background: none; border: 1px solid #fee2e2; color: #ef4444; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: var(--transition);">
                                Nonaktifkan
                            </button>
                            @else
                            <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Promo -->
<div id="promo-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: white; border-radius: var(--radius-lg); width: 480px; max-width: 95%; overflow: hidden; box-shadow: var(--shadow-xl); animation: slideUp 0.3s ease-out;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; color: var(--primary);">Buat Kode Promo Baru</h4>
            <button onclick="closePromoModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <div style="padding: 1.5rem;">
            <div style="margin-bottom: 1.25rem;">
                <label for="promo-code" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Kode Promo (Kapital, tanpa spasi)</label>
                <input type="text" id="promo-code" placeholder="Contoh: VILLAHEMAT" style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 1rem; outline: none; text-transform: uppercase;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <label for="promo-discount" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Diskon (%)</label>
                    <input type="number" id="promo-discount" min="1" max="100" placeholder="Contoh: 15" style="width: 100%; box-sizing: border-box; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; outline: none;">
                </div>
                <div>
                    <label for="promo-target" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Properti Sasaran</label>
                    <select id="promo-target" style="width: 100%; box-sizing: border-box; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; outline: none; background: white; cursor: pointer;">
                        <option value="Semua Properti">Semua Properti</option>
                        @foreach($properties as $prop)
                        <option value="{{ $prop->title }}">{{ $prop->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label for="promo-start" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Tanggal Mulai</label>
                    <input type="date" id="promo-start" style="width: 100%; box-sizing: border-box; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; outline: none;">
                </div>
                <div>
                    <label for="promo-end" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Tanggal Berakhir</label>
                    <input type="date" id="promo-end" style="width: 100%; box-sizing: border-box; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; outline: none;">
                </div>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button onclick="closePromoModal()" style="flex: 1; padding: 0.75rem; border: 1px solid var(--border); background: white; border-radius: var(--radius-md); font-weight: 600; cursor: pointer;">Batal</button>
                <button onclick="savePromo()" style="flex: 1; padding: 0.75rem; border: none; background: var(--secondary); color: white; border-radius: var(--radius-md); font-weight: 600; cursor: pointer;">Buat Promo</button>
            </div>
        </div>
    </div>
</div>

<script>
    let nextPromoId = 4;

    function openPromoModal() {
        document.getElementById('promo-modal').style.display = 'flex';
        // Set default dates
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('promo-start').value = today;
    }

    function closePromoModal() {
        document.getElementById('promo-modal').style.display = 'none';
    }

    function deactivatePromo(id) {
        if (confirm('Apakah Anda yakin ingin menonaktifkan kode promo ini?')) {
            const row = document.getElementById(`promo-row-${id}`);
            if (row) {
                const badge = row.querySelector('.status-badge');
                badge.textContent = 'Berakhir';
                badge.style.background = 'rgba(239, 68, 68, 0.1)';
                badge.style.color = '#ef4444';
                
                const actionCell = row.querySelector('td:last-child');
                actionCell.innerHTML = '<span style="color: var(--text-muted); font-size: 0.85rem;">-</span>';
            }
        }
    }

    function formatDateStr(dateStr) {
        const date = new Date(dateStr);
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    function savePromo() {
        const codeInput = document.getElementById('promo-code');
        const code = codeInput.value.toUpperCase().replace(/\s+/g, '');
        const discount = document.getElementById('promo-discount').value;
        const target = document.getElementById('promo-target').value;
        const startDate = document.getElementById('promo-start').value;
        const endDate = document.getElementById('promo-end').value;

        if (!code) {
            alert('Silakan masukkan Kode Promo.');
            return;
        }
        if (!discount || discount < 1 || discount > 100) {
            alert('Silakan masukkan diskon persen yang valid (1-100).');
            return;
        }
        if (!startDate || !endDate) {
            alert('Silakan pilih masa berlaku promo.');
            return;
        }

        const tbody = document.getElementById('promo-tbody');
        const newRow = document.createElement('tr');
        const currentId = nextPromoId++;
        newRow.className = 'promo-row';
        newRow.id = `promo-row-${currentId}`;
        newRow.style.borderBottom = '1px solid var(--border)';
        newRow.style.fontSize = '0.95rem';

        newRow.innerHTML = `
            <td style="padding: 1rem 0;">
                <code style="font-family: monospace; background: var(--bg-light); border: 1px dashed var(--border); padding: 0.35rem 0.65rem; border-radius: 4px; font-weight: 700; color: var(--primary); font-size: 0.95rem;">
                    ${code}
                </code>
            </td>
            <td style="font-weight: 700; color: #22c55e;">${discount}% Diskon</td>
            <td style="font-weight: 500; color: var(--text-main);">${target}</td>
            <td style="color: var(--text-muted); font-size: 0.9rem;">
                ${formatDateStr(startDate)} - ${formatDateStr(endDate)}
            </td>
            <td style="font-weight: 600; color: var(--text-main);">0x terpakai</td>
            <td>
                <span class="status-badge" style="font-weight: 600; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 4px; background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                    Aktif
                </span>
            </td>
            <td style="text-align: right;">
                <button onclick="deactivatePromo(${currentId})" class="btn-deactivate" style="background: none; border: 1px solid #fee2e2; color: #ef4444; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: var(--transition);">
                    Nonaktifkan
                </button>
            </td>
        `;

        tbody.insertBefore(newRow, tbody.firstChild);
        
        // Update count
        const currentCount = parseInt(document.getElementById('promo-count').textContent);
        document.getElementById('promo-count').textContent = currentCount + 1;

        closePromoModal();
        
        // Clear input values
        codeInput.value = '';
        document.getElementById('promo-discount').value = '';
        
        alert(`Kode promo ${code} berhasil dibuat!`);
    }
</script>

<style>
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .btn-deactivate:hover {
        background-color: #fee2e2 !important;
    }
</style>

@endsection
