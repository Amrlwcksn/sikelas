@extends('layouts.admin')

@section('title', 'Input Transaksi')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Input Transaksi</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Catat setoran kas atau pengeluaran mahasiswa.</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 2.5rem;">
    <div class="card" style="height: fit-content;">
        <div class="mb-8">
            <h3 class="text-xl font-bold">Form Pencatatan</h3>
            <p style="font-size: 0.875rem; color: var(--text-muted);">Isi detail transaksi di bawah ini.</p>
        </div>
        
        <form action="{{ route('admin.transactions.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
            @csrf
            <div>
                <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="user" style="width: 16px;"></i> Mahasiswa
                </label>
                <select name="account_id" id="student_select" required onchange="updateBalance()">
                    <option value="" data-balance="0">-- Pilih Mahasiswa --</option>
                    @foreach ($students as $s)
                        @if($s->account)
                            <option value="{{ $s->account->id }}" data-balance="{{ $balances[$s->account->id] ?? 0 }}">
                                {{ $s->name }} ({{ $s->npm }})
                            </option>
                        @endif
                    @endforeach
                </select>
                <div id="balance_info" style="margin-top: 1rem; font-size: 0.875rem; font-weight: 700; color: var(--primary); display: none; background: var(--primary-light); padding: 1rem 1.25rem; border-radius: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>Saldo Terkini</span>
                        <span id="current_balance_display">Rp 0</span>
                    </div>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                <div>
                    <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                        <i data-lucide="layers" style="width: 16px;"></i> Jenis
                    </label>
                    <select name="jenis" required>
                        <option value="setor">Setoran (Masuk)</option>
                        <option value="keluar">Penarikan (Keluar)</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                        <i data-lucide="calendar" style="width: 16px;"></i> Tanggal
                    </label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <div>
                <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="banknote" style="width: 16px;"></i> Nominal (Rp)
                </label>
                <input type="number" name="jumlah" required min="1" placeholder="0" style="font-size: 1.25rem; font-weight: 800;">
            </div>

            <div>
                <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="file-text" style="width: 16px;"></i> Keterangan
                </label>
                <textarea name="keterangan" rows="2" placeholder="Contoh: Iuran Kas Maret" style="border-radius: 1rem;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 1rem; width: 100%;">
                <i data-lucide="save"></i> Simpan Transaksi
            </button>
        </form>
    </div>

    <div class="table-container" style="height: fit-content; margin-top: 0;">
        <div style="padding: 2rem; border-bottom: 2px solid var(--bg-main); display: flex; justify-content: space-between; align-items: center;">
            <h3 class="text-xl font-bold">Riwayat Transaksi</h3>
            <div class="status-badge status-success" style="font-size: 0.65rem;">
                <i data-lucide="refresh-cw" style="width: 12px; height: 12px;"></i> LIVE
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 120px;">Waktu</th>
                    <th>Mahasiswa</th>
                    <th style="text-align: right;">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($history as $tx)
                    <tr>
                        <td style="font-size: 0.875rem; color: var(--text-muted); font-weight: 600;">{{ \Carbon\Carbon::parse($tx->tanggal)->format('d M Y') }}</td>
                        <td>
                            <div style="font-weight: 700; color: var(--text-main);">{{ $tx->account->user->name ?? 'N/A' }}</div>
                            <div style="font-size: 0.8125rem; color: var(--text-muted);">{{ $tx->keterangan ?? 'Iuran Kas' }}</div>
                        </td>
                        <td style="text-align: right; font-weight: 800; color: {{ $tx->jenis === 'setor' ? 'var(--success)' : 'var(--danger)' }}; font-size: 1.125rem;">
                            {{ ($tx->jenis === 'setor' ? '+' : '-') }} {{ number_format($tx->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="3" align="center" style="padding: 5rem; color: var(--text-muted);">
                        <i data-lucide="history" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                        <p style="font-weight: 600;">Belum ada riwayat transaksi hari ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
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
