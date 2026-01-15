@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
<!-- Digital Bank Card -->
<!-- Minimalist Digital Card -->
<div class="glass-card" style="margin-bottom: 2rem; background: var(--grad-banking); padding: 1.75rem; border-radius: 1.5rem; position: relative; overflow: hidden; color: white; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.3);">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(37, 99, 235, 0.3) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2.5rem; position: relative; z-index: 10;">
        <div>
            <div style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; color: rgba(255,255,255,0.6); margin-bottom: 0.25rem;">Total Balance</div>
            <div style="font-size: 2.25rem; font-weight: 900; letter-spacing: -0.05em; line-height: 1;">Rp {{ number_format($myBalance, 0, ',', '.') }}</div>
        </div>
        <div style="width: 38px; height: 38px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.2);">
            <i data-lucide="wallet" style="width: 20px; height: 20px; color: white;"></i>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: flex-end; position: relative; z-index: 10;">
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <div style="width: 32px; height: 32px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-weight: 950; font-size: 0.8rem;">G</div>
            <div>
                <div style="font-size: 0.9rem; font-weight: 700;">{{ auth()->user()->name }}</div>
                <div style="font-size: 0.7rem; color: rgba(255,255,255,0.6); font-weight: 500;">{{ auth()->user()->npm }}</div>
            </div>
        </div>
        <div style="font-size: 0.65rem; font-weight: 700; background: rgba(59, 130, 246, 0.3); padding: 0.25rem 0.75rem; border-radius: 2rem; border: 1px solid rgba(59, 130, 246, 0.4); text-transform: uppercase; letter-spacing: 0.1em;">
            Active
        </div>
    </div>
</div>

<!-- Quick Stats Grid -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
    <div class="glass-card" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.75rem;">
        <div style="width: 32px; height: 32px; background: rgba(16, 185, 129, 0.1); color: var(--success); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="users" style="width: 16px;"></i>
        </div>
        <div>
            <div style="font-size: 0.65rem; font-weight: 700; color: var(--secondary); text-transform: uppercase;">Kas Kelas</div>
            <div style="font-size: 1rem; font-weight: 800;">Rp {{ number_format($totalClassCash, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="glass-card" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.75rem;">
        <div style="width: 32px; height: 32px; background: rgba(37, 99, 235, 0.1); color: var(--primary-accent); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="calendar" style="width: 16px;"></i>
        </div>
        <div>
            <div style="font-size: 0.65rem; font-weight: 700; color: var(--secondary); text-transform: uppercase;">Terakhir Bayar</div>
            <div style="font-size: 1rem; font-weight: 800;">
                {{ $recentTransactions->where('jenis', 'setor')->first() ? \Carbon\Carbon::parse($recentTransactions->where('jenis', 'setor')->first()->tanggal)->format('d M y') : '-' }}
            </div>
        </div>
    </div>
</div>

<!-- Verification Banner -->
<div class="glass-card" style="background: rgba(255, 255, 255, 0.5); padding: 1rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; border-radius: 1rem;">
    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-light); color: var(--primary-accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
        <i data-lucide="shield-check" style="width: 18px;"></i>
    </div>
    <p style="font-size: 0.8125rem; color: var(--text-muted); font-weight: 500; margin: 0;">
        Transaksi aman & terverifikasi oleh pengurus.
    </p>
</div>

<!-- Balance Validation Info -->
<div class="glass-card" style="padding: 1.25rem; margin-bottom: 2.5rem; border-left: 4px solid var(--primary-accent); background: white;">
    <div style="display: flex; gap: 1rem; align-items: start;">
        <div style="width: 38px; height: 38px; background: rgba(37, 99, 235, 0.1); color: var(--primary-accent); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i data-lucide="file-check" style="width: 20px;"></i>
        </div>
        <div>
            <h4 style="font-size: 0.9375rem; font-weight: 800; color: var(--primary); margin-bottom: 0.25rem;">Validasi Saldo Individu</h4>
            <p style="font-size: 0.8125rem; color: var(--secondary); line-height: 1.5; margin-bottom: 0.75rem;">
                Ingin mencetak bukti saldo resmi? Hubungi <strong>Bendahara Kelas</strong> untuk meminta "Surat Validasi Cek Saldo" (FIN-02). Dokumen ini berfungsi sebagai bukti sah kepemilikan tabungan kas kelas Anda di sistem Sikelas.
            </p>
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(37, 99, 235, 0.05); padding: 0.5rem 1rem; border-radius: 0.75rem; border: 1px dashed var(--primary-accent);">
                <i data-lucide="printer" style="width: 14px; color: var(--primary-accent);"></i>
                <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary-accent);">Kode Dokumen: FIN-02.VLD.SALDO</span>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; padding: 0 0.5rem;">
    <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary);">{{ $view === 'history' ? 'Riwayat Transaksi' : 'Aktivitas Terbaru' }}</h3>
    @if($view !== 'history')
        <a href="{{ route('student.dashboard', ['view' => 'history']) }}" style="font-size: 0.8125rem; color: var(--primary-accent); font-weight: 700; text-decoration: none;">Lihat Semua</a>
    @else
        <a href="{{ route('student.dashboard') }}" style="font-size: 0.8125rem; color: var(--secondary); font-weight: 700; text-decoration: none;">Tutup</a>
    @endif
</div>

<!-- Transactions List -->
<div style="display: flex; flex-direction: column; gap: 1rem;">
    @forelse ($recentTransactions as $tx)
        <div class="glass-card" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; background: {{ $tx->jenis === 'setor' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $tx->jenis === 'setor' ? 'var(--success)' : 'var(--danger)' }};">
                    <i data-lucide="{{ $tx->jenis === 'setor' ? 'trending-up' : 'trending-down' }}" style="width: 22px;"></i>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 0.9375rem; color: var(--primary);">{{ $tx->keterangan ?? 'Setoran Kas' }}</div>
                    <div style="font-size: 0.75rem; color: var(--secondary); margin-top: 0.125rem;">{{ \Carbon\Carbon::parse($tx->tanggal)->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
            <div style="text-align: right;">
                <div style="font-weight: 800; font-size: 1rem; color: {{ $tx->jenis === 'setor' ? 'var(--success)' : 'var(--danger)' }};">
                    {{ ($tx->jenis === 'setor' ? '+' : '-') }}Rp {{ number_format($tx->jumlah, 0, ',', '.') }}
                </div>
                <div class="status-badge status-{{ $tx->jenis === 'setor' ? 'success' : 'danger' }}" style="padding: 0.125rem 0.5rem; font-size: 0.6rem; margin-top: 0.375rem; border: none; background: transparent;">
                    BERHASIL
                </div>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 4rem 2rem; opacity: 0.5;">
            <i data-lucide="ghost" style="width: 48px; height: 48px; margin: 0 auto 1.5rem;"></i>
            <p style="font-weight: 600;">Belum ada riwayat transaksi</p>
        </div>
    @endforelse
</div>

<!-- Bottom Menu / Settings Link -->
<div style="margin-top: 3rem; text-align: center;">
    <a href="{{ route('student.settings') }}" class="btn btn-outline" style="width: 100%; border-radius: 1rem;">
        <i data-lucide="settings"></i>
        <span>Pengaturan Akun</span>
    </a>
    <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
        @csrf
        <button type="submit" style="background: none; border: none; color: var(--danger); font-size: 0.875rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="log-out" style="width: 16px;"></i>
            Keluar Aplikasi
        </button>
    </form>
</div>
@endsection
