@extends('layouts.admin')

@section('title', 'Input Transaksi')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Pencatatan Transaksi</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Kelola setoran kas dan pengeluaran operasional kelas.</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 2.5rem;">
    <!-- Form Side -->
    <div class="glass-card" style="background: white; height: fit-content; padding: 2rem;">
        <div class="mb-8 flex items-center gap-3">
            <div style="width: 40px; height: 40px; background: var(--primary-light); color: var(--primary-accent); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="pen-tool" style="width: 20px; height: 20px;"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold">Input Data</h3>
                <p style="font-size: 0.75rem; color: var(--text-muted);">Masukkan rincian transaksi perbankan.</p>
            </div>
        </div>
        
        <form action="{{ route('admin.transactions.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.75rem;">
            @csrf
            <div class="form-group">
                <label style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                    <i data-lucide="user" style="width: 14px;"></i> Pilih Nasabah / Mahasiswa
                </label>
                <select name="account_id" id="student_select" required onchange="updateBalance()" style="background: var(--bg-main); font-weight: 600;">
                    <option value="" data-balance="0">-- Pilih Nama Mahasiswa --</option>
                    @foreach ($students as $s)
                        @if($s->account)
                            <option value="{{ $s->account->id }}" data-balance="{{ $balances[$s->account->id] ?? 0 }}">
                                {{ $s->name }} ({{ $s->npm }})
                            </option>
                        @endif
                    @endforeach
                </select>
                <div id="balance_info" style="margin-top: 1rem; display: none;">
                    <div style="background: var(--grad-banking); color: white; padding: 1.25rem; border-radius: 1.25rem; box-shadow: var(--shadow-soft);">
                        <div style="font-size: 0.7rem; font-weight: 700; opacity: 0.8; text-transform: uppercase;">Saldo Terkini Nasabah</div>
                        <div id="current_balance_display" style="font-size: 1.5rem; font-weight: 900; letter-spacing: -0.5px; margin-top: 0.25rem;">Rp 0</div>
                    </div>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <i data-lucide="activity" style="width: 14px;"></i> Status
                    </label>
                    <select name="jenis" required style="background: var(--bg-main); font-weight: 600;">
                        <option value="setor">Deposit (Masuk)</option>
                        <option value="keluar">Withdraw (Keluar)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <i data-lucide="calendar" style="width: 14px;"></i> Waktu
                    </label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required style="background: var(--bg-main); font-weight: 600;">
                </div>
            </div>

            <div class="form-group">
                <label style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                    <i data-lucide="banknote" style="width: 14px;"></i> Nilai Nominal (IDR)
                </label>
                <input type="number" name="jumlah" required min="1" placeholder="0" style="font-size: 1.5rem; font-weight: 950; padding: 1rem 1.25rem;">
            </div>

            <div class="form-group">
                <label style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                    <i data-lucide="file-text" style="width: 14px;"></i> Deskripsi Internal
                </label>
                <textarea name="keterangan" rows="2" placeholder="Tuliskan alasan transaksi..." style="background: var(--bg-main); border-radius: 1rem; font-weight: 500;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 1rem; width: 100%; padding: 1.25rem; border-radius: 1.25rem; font-size: 1.125rem;">
                <i data-lucide="check-circle-2"></i> Jalankan Transaksi
            </button>
        </form>
    </div>

    <!-- Table Side -->
    <div class="table-container glass-card" style="background: white; height: fit-content; margin-top: 0; padding: 0;">
        <div style="padding: 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border);">
            <div>
                <h3 class="text-xl font-bold">Log Aktivitas</h3>
                <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 500;">Monitor transaksi terbaru nasabah.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800;">
                <div class="w-2 h-2 rounded-full bg-success animate-pulse"></div>
                LIVE FEED
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 1.25rem 2rem; background: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: var(--secondary); font-weight: 800; border-bottom: 1px solid var(--border);">Waktu</th>
                        <th style="padding: 1.25rem 2rem; background: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: var(--secondary); font-weight: 800; border-bottom: 1px solid var(--border);">Nasabah</th>
                        <th style="padding: 1.25rem 2rem; background: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: var(--secondary); font-weight: 800; border-bottom: 1px solid var(--border); text-align: right;">Mutasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($history as $tx)
                        <tr>
                            <td style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border); font-size: 0.8125rem; color: var(--text-muted); font-weight: 600;">{{ \Carbon\Carbon::parse($tx->tanggal)->translatedFormat('d M Y') }}</td>
                            <td style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="font-weight: 800; color: var(--primary);">{{ $tx->account->user->name ?? 'N/A' }}</div>
                                    <span style="font-size: 0.65rem; font-weight: 800; background: #e2e8f0; color: #475569; padding: 0.125rem 0.5rem; border-radius: 0.5rem;">{{ $tx->account->user->npm ?? '-' }}</span>
                                </div>
                                <div style="font-size: 0.75rem; color: var(--secondary); font-weight: 500; margin-top: 0.125rem;">{{ $tx->keterangan ?? 'Setoran Kas' }}</div>
                            </td>
                            <td style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border); text-align: right;">
                                <div style="font-weight: 900; font-size: 1.125rem; color: {{ $tx->jenis === 'setor' ? 'var(--success)' : 'var(--danger)' }};">
                                    {{ ($tx->jenis === 'setor' ? '+' : '-') }} {{ number_format($tx->jumlah, 0, ',', '.') }}
                                </div>
                                <div style="font-size: 0.625rem; font-weight: 800; color: var(--text-muted); margin-top: 0.25rem;">VERIFIED</div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="3" align="center" style="padding: 6rem 2rem; color: var(--text-muted);">
                            <div style="opacity: 0.3;">
                                <i data-lucide="history" style="width: 48px; height: 48px; margin: 0 auto 1.5rem;"></i>
                                <p style="font-weight: 700;">Belum ada riwayat transaksi hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateBalance() {
    const select = document.getElementById('student_select');
    const display = document.getElementById('balance_info');
    const span = document.getElementById('current_balance_display');
    
    const selectedOption = select.options[select.selectedIndex];
    const balance = selectedOption.getAttribute('data-balance');
    
    if (select.value) {
        display.style.display = 'block';
        span.innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(balance);
    } else {
        display.style.display = 'none';
    }
}
</script>
@endpush
