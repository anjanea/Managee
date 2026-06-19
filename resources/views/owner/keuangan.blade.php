@extends('layouts.owner')

@section('title', 'Dashboard Pemilik Managee - Keuangan')
@section('page_title', 'Keuangan & Pendapatan')

@section('content')

<!-- Stats Grid -->
<div class="owner-stats-grid" style="margin-bottom: 2.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
    <!-- Active Balance Card -->
    <div class="stat-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 1rem; position: relative; overflow: hidden;">
        <div class="stat-icon-wrapper" style="background: rgba(34, 197, 94, 0.1); color: #22c55e; border-radius: var(--radius-md); width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2" ry="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
        </div>
        <div class="stat-info" style="flex: 1;">
            <span class="stat-label" style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Saldo Aktif (Dapat Ditarik)</span>
            <span class="stat-value" id="active-balance-text" style="font-size: 1.75rem; font-weight: 700; color: var(--text-main); display: block;">Rp {{ number_format($keuangan['saldo_aktif'], 0, ',', '.') }}</span>
        </div>
        <button onclick="openWithdrawModal()" class="btn-tarik" style="background: var(--secondary); color: white; border: none; padding: 0.6rem 1.2rem; font-weight: 600; font-size: 0.85rem; border-radius: var(--radius-md); cursor: pointer; transition: var(--transition); box-shadow: var(--shadow-sm);">Tarik Dana</button>
    </div>

    <!-- Pending Balance Card -->
    <div class="stat-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 1rem;">
        <div class="stat-icon-wrapper" style="background: rgba(202, 138, 4, 0.1); color: var(--secondary); border-radius: var(--radius-md); width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
        <div class="stat-info">
            <span class="stat-label" style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Dana Tertahan (Pemesanan Aktif)</span>
            <span class="stat-value" style="font-size: 1.75rem; font-weight: 700; color: var(--text-main); display: block;">Rp {{ number_format($keuangan['saldo_tertahan'], 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Total Revenue Card -->
    <div class="stat-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 1rem;">
        <div class="stat-icon-wrapper" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9; border-radius: var(--radius-md); width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
        </div>
        <div class="stat-info">
            <span class="stat-label" style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Total Akumulasi Pendapatan</span>
            <span class="stat-value" style="font-size: 1.75rem; font-weight: 700; color: var(--text-main); display: block;">Rp {{ number_format($keuangan['total_pendapatan'], 0, ',', '.') }}</span>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; flex-wrap: wrap;">
    <!-- Transaction History -->
    <div class="owner-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
        <div class="card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; color: var(--primary);">Riwayat Transaksi</h4>
            <select id="filter-type" onchange="filterTransactions()" style="padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; font-size: 0.85rem; background: var(--bg-light); cursor: pointer;">
                <option value="all">Semua Tipe</option>
                <option value="pemasukan">Pemasukan</option>
                <option value="penarikan">Penarikan Dana</option>
            </select>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div class="table-responsive">
                <table class="owner-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border); font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted);">
                            <th style="padding: 0.75rem 0.5rem; text-align: left;">Tanggal</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: left;">Tipe</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: left;">Deskripsi</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: left;">Jumlah (IDR)</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: right;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-tbody">
                        @foreach($keuangan['riwayat_transaksi'] as $tx)
                        <tr class="tx-row" data-type="{{ strpos($tx['tipe'], 'Penarikan') !== false ? 'penarikan' : 'pemasukan' }}" style="border-bottom: 1px solid var(--border); font-size: 0.95rem; transition: var(--transition);">
                            <td style="padding: 1rem 0.5rem; color: var(--text-muted);">{{ $tx['tanggal'] }}</td>
                            <td style="padding: 1rem 0.5rem;">
                                <span style="font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; 
                                    background: {{ $tx['tipe'] == 'Pemasukan' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(59, 130, 246, 0.1)' }}; 
                                    color: {{ $tx['tipe'] == 'Pemasukan' ? '#22c55e' : '#3b82f6' }};">
                                    {{ $tx['tipe'] }}
                                </span>
                            </td>
                            <td style="padding: 1rem 0.5rem; font-weight: 500; color: var(--text-main);">{{ $tx['deskripsi'] }}</td>
                            <td style="padding: 1rem 0.5rem; font-weight: 600; color: {{ $tx['jumlah'] > 0 ? '#22c55e' : '#ef4444' }};">
                                {{ $tx['jumlah'] > 0 ? '+' : '' }}Rp {{ number_format($tx['jumlah'], 0, ',', '.') }}
                            </td>
                            <td style="padding: 1rem 0.5rem; text-align: right;">
                                <span style="font-weight: 600; font-size: 0.8rem; color: #22c55e;">
                                    ● {{ $tx['status'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bank Info & Payout Target -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Bank Target Account -->
        <div class="owner-card" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
            <div class="card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--border);">
                <h4 style="margin: 0; color: var(--primary);">Rekening Bank Tujuan</h4>
            </div>
            <div class="card-body" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                <div style="background: var(--bg-light); border-radius: var(--radius-md); padding: 1rem; border: 1px solid var(--border);">
                    <div style="font-weight: 700; color: var(--text-main); font-size: 1rem; margin-bottom: 0.25rem;">{{ $keuangan['bank_info']['nama_bank'] }}</div>
                    <div style="font-family: monospace; font-size: 1.1rem; letter-spacing: 1px; color: var(--text-main); margin-bottom: 0.5rem;">
                        {{ substr($keuangan['bank_info']['nomor_rekening'], 0, 4) }} **** **** {{ substr($keuangan['bank_info']['nomor_rekening'], -2) }}
                    </div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Atas Nama</div>
                    <div style="font-weight: 600; color: var(--text-main);">{{ $keuangan['bank_info']['nama_pemilik'] }}</div>
                </div>
                <button onclick="openBankModal()" class="btn" style="background: none; border: 1px solid var(--border); padding: 0.6rem; border-radius: var(--radius-md); font-weight: 600; font-size: 0.85rem; color: var(--text-main); cursor: pointer; transition: var(--transition); display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4z"></path></svg>
                    <span>Ubah Rekening</span>
                </button>
            </div>
        </div>

        <!-- Tips & Simulation Notice -->
        <div style="background: rgba(14, 165, 233, 0.08); border: 1px solid rgba(14, 165, 233, 0.2); border-radius: var(--radius-lg); padding: 1.25rem; color: var(--text-main);">
            <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                <svg style="color: #0ea5e9; flex-shrink: 0;" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <div style="font-size: 0.85rem; line-height: 1.4;">
                    <strong style="display: block; margin-bottom: 0.25rem; color: var(--primary);">Informasi Penarikan Dana</strong>
                    Proses penarikan dana diproses maksimal dalam 1x24 jam di hari kerja. Dana tertahan akan otomatis dilepaskan ke Saldo Aktif 2 hari setelah status sewa selesai (H+2 Keluar).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Laporan Detailed Table (Consolidated) -->
<div class="owner-card" style="margin-top: 2rem; margin-bottom: 2rem; background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
    <div class="card-header" style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border);">
        <h4 style="margin: 0; color: var(--primary);">Laporan Bulanan & Performa Hunian</h4>
        <a href="{{ route('owner.keuangan.export') }}" class="btn" style="background-color: var(--secondary); color: white; border: none; text-decoration: none; padding: 0.5rem 1rem; border-radius: var(--radius-md); font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem; transition: var(--transition);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Ekspor Laporan (CSV)</span>
        </a>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <div class="table-responsive">
            <table class="owner-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border); font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted);">
                        <th style="padding: 0.75rem 0;">Bulan</th>
                        <th>Pendapatan Kotor (IDR)</th>
                        <th>Kuantitas Pemesanan</th>
                        <th>Tingkat Hunian (Okupansi)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr style="border-bottom: 1px solid var(--border); font-size: 0.95rem;">
                            <td style="font-weight: 600; color: var(--text-main); padding: 1rem 0;">{{ $report['month'] }}</td>
                            <td style="font-weight: 600; color: var(--primary);">Rp {{ number_format($report['revenue'], 0, ',', '.') }}</td>
                            <td style="color: var(--text-main);">{{ $report['bookings'] }} Pemesanan</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="flex: 1; background: #e2e8f0; height: 8px; border-radius: 4px; max-width: 120px; overflow: hidden;">
                                        <div style="background: var(--secondary); width: {{ $report['occupancy'] }}%; height: 100%;"></div>
                                    </div>
                                    <span style="font-weight: 600; color: var(--text-main);">{{ $report['occupancy'] }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Withdraw -->
<div id="withdraw-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: white; border-radius: var(--radius-lg); width: 420px; max-width: 90%; overflow: hidden; box-shadow: var(--shadow-xl); animation: slideUp 0.3s ease-out;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; color: var(--primary);">Tarik Dana Mandiri</h4>
            <button onclick="closeWithdrawModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <div style="padding: 1.5rem;">
            <div style="margin-bottom: 1.25rem;">
                <label style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Rekening Tujuan</label>
                <div style="background: var(--bg-light); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 0.75rem 1rem;">
                    <strong style="display: block; font-size: 0.9rem;">BCA - 8012****11</strong>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">a.n. {{ auth()->user()->name }}</span>
                </div>
            </div>
            <div style="margin-bottom: 1.25rem;">
                <label for="withdraw-amount" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Nominal Penarikan (Rp)</label>
                <input type="number" id="withdraw-amount" placeholder="Contoh: 10000000" style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-family: inherit; font-size: 1rem; outline: none;">
                <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">Batas maksimum penarikan: Rp {{ number_format($keuangan['saldo_aktif'], 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button onclick="closeWithdrawModal()" style="flex: 1; padding: 0.75rem; border: 1px solid var(--border); background: white; border-radius: var(--radius-md); font-weight: 600; cursor: pointer;">Batal</button>
                <button onclick="processWithdraw()" style="flex: 1; padding: 0.75rem; border: none; background: var(--secondary); color: white; border-radius: var(--radius-md); font-weight: 600; cursor: pointer;">Tarik Sekarang</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bank Info -->
<div id="bank-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: white; border-radius: var(--radius-lg); width: 420px; max-width: 90%; overflow: hidden; box-shadow: var(--shadow-xl);">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; color: var(--primary);">Ubah Rekening Bank</h4>
            <button onclick="closeBankModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <div style="padding: 1.5rem;">
            <div style="margin-bottom: 1.25rem;">
                <label for="bank-name" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Nama Bank</label>
                <select id="bank-name" style="width: 100%; box-sizing: border-box; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none;">
                    <option value="Bank Central Asia (BCA)">BCA</option>
                    <option value="Bank Mandiri">Mandiri</option>
                    <option value="Bank Rakyat Indonesia (BRI)">BRI</option>
                    <option value="Bank Negara Indonesia (BNI)">BNI</option>
                </select>
            </div>
            <div style="margin-bottom: 1.25rem;">
                <label for="bank-number" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Nomor Rekening</label>
                <input type="text" id="bank-number" value="8012998811" style="width: 100%; box-sizing: border-box; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none;">
            </div>
            <div style="margin-bottom: 1.25rem;">
                <label for="bank-owner" style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.35rem;">Nama Pemilik Rekening</label>
                <input type="text" id="bank-owner" value="{{ auth()->user()->name }}" style="width: 100%; box-sizing: border-box; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none;">
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button onclick="closeBankModal()" style="flex: 1; padding: 0.75rem; border: 1px solid var(--border); background: white; border-radius: var(--radius-md); font-weight: 600; cursor: pointer;">Batal</button>
                <button onclick="saveBankInfo()" style="flex: 1; padding: 0.75rem; border: none; background: var(--secondary); color: white; border-radius: var(--radius-md); font-weight: 600; cursor: pointer;">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    let saldoAktif = {{ $keuangan['saldo_aktif'] }};

    function filterTransactions() {
        const type = document.getElementById('filter-type').value;
        const rows = document.querySelectorAll('.tx-row');
        rows.forEach(row => {
            if (type === 'all' || row.getAttribute('data-type') === type) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function openWithdrawModal() {
        document.getElementById('withdraw-modal').style.display = 'flex';
    }

    function closeWithdrawModal() {
        document.getElementById('withdraw-modal').style.display = 'none';
    }

    function openBankModal() {
        document.getElementById('bank-modal').style.display = 'flex';
    }

    function closeBankModal() {
        document.getElementById('bank-modal').style.display = 'none';
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    function processWithdraw() {
        const amountInput = document.getElementById('withdraw-amount');
        const amount = parseInt(amountInput.value);

        if (!amount || amount <= 0) {
            alert('Silakan masukkan nominal penarikan yang valid.');
            return;
        }

        if (amount > saldoAktif) {
            alert('Saldo tidak mencukupi untuk melakukan penarikan.');
            return;
        }

        saldoAktif -= amount;
        document.getElementById('active-balance-text').textContent = formatRupiah(saldoAktif).replace("IDR", "Rp");
        
        // Append new transaction to table
        const tbody = document.getElementById('transaction-tbody');
        const newRow = document.createElement('tr');
        newRow.className = 'tx-row';
        newRow.setAttribute('data-type', 'penarikan');
        newRow.style.borderBottom = '1px solid var(--border)';
        newRow.style.fontSize = '0.95rem';

        const today = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

        newRow.innerHTML = `
            <td style="padding: 1rem 0; color: var(--text-muted);">${today}</td>
            <td>
                <span style="font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                    Penarikan Dana
                </span>
            </td>
            <td style="font-weight: 500; color: var(--text-main);">Penarikan Dana ke BCA ({{ auth()->user()->name }})</td>
            <td style="font-weight: 600; color: #ef4444;">-Rp ${new Intl.NumberFormat('id-ID').format(amount)}</td>
            <td style="text-align: right;">
                <span style="font-weight: 600; font-size: 0.8rem; color: #eab308;">
                    ● Diproses
                </span>
            </td>
        `;

        tbody.insertBefore(newRow, tbody.firstChild);
        closeWithdrawModal();
        amountInput.value = '';
        alert('Penarikan dana berhasil diajukan dan sedang diproses!');
    }

    function saveBankInfo() {
        const bankName = document.getElementById('bank-name').value;
        const bankNumber = document.getElementById('bank-number').value;
        const bankOwner = document.getElementById('bank-owner').value;

        alert('Informasi rekening berhasil disimpan!');
        closeBankModal();
        location.reload();
    }
</script>

<style>
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .btn-tarik:hover {
        background-color: var(--primary) !important;
        transform: translateY(-1px);
    }
</style>

@endsection
