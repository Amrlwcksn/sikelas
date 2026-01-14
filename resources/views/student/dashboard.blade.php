@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <div>
        <h2 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 950; font-size: 1.35rem; color: var(--primary); letter-spacing: -1.2px;">Sikelas.</h2>
        <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">Dashboard Mahasiswa</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('student.settings') }}" class="btn" style="width: 40px; height: 40px; padding: 0; background: white; color: var(--text-main); box-shadow: var(--shadow); border-radius: 12px;">
            <i data-lucide="settings" style="width: 18px;"></i>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn" style="height: 40px; background: #fff1f2; color: var(--danger); padding: 0 1rem; font-size: 0.75rem;">
                <i data-lucide="log-out" style="width: 14px; margin-right: 4px;"></i> Logout
            </button>
        </form>
    </div>
</div>

<!-- Main Balance Card: Blue Accent -->
<div class="atm-card bg-silhouette" style="margin-bottom: 2rem; height: 180px;">
    <svg class="pattern" viewBox="0 0 100 100" preserveAspectRatio="none">
        <circle cx="10" cy="10" r="40" fill="white" />
        <circle cx="90" cy="90" r="30" fill="white" />
    </svg>
    <div class="atm-card-header">
        <div class="atm-card-chip"></div>
        <div style="text-align: right;">
            <span style="font-size: 0.55rem; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; opacity: 0.7;">Saldo Kas Anda</span>
        </div>
    </div>
    
    <div>
        <span style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8;">Total Tabungan</span>
        <h3 style="font-size: 2rem; font-weight: 950; letter-spacing: -1.2px; margin-top: 0.125rem;">Rp {{ number_format($myBalance, 0, ',', '.') }}</h3>
    </div>

    <div class="atm-card-footer">
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 0.875rem; font-weight: 800;">{{ auth()->user()->name }}</span>
            <span style="font-size: 0.7rem; opacity: 0.7;">{{ auth()->user()->npm }}</span>
        </div>
        <div style="font-size: 0.65rem; font-weight: 900; opacity: 0.4;">SIKELAS DIGITAL</div>
    </div>
</div>

<!-- Grid for 2 other high-impact cards -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
    <!-- Collective Cash Card: Emerald Accent -->
    <div class="card bg-silhouette" style="background: var(--grad-success); margin-bottom: 0; padding: 1.25rem; height: 140px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);">
        <svg class="pattern" viewBox="0 0 100 100" preserveAspectRatio="none">
            <rect x="0" y="0" width="100" height="2" fill="white" />
            <rect x="0" y="20" width="100" height="2" fill="white" />
            <rect x="0" y="40" width="100" height="2" fill="white" />
        </svg>
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="users" style="width: 16px; color: white;"></i>
            </div>
            <span style="font-size: 0.55rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8;">Kas Kelas</span>
        </div>
        <div>
            <div style="font-size: 0.6rem; font-weight: 700; opacity: 0.9; margin-bottom: 0.125rem;">Himpunan Kolektif</div>
            <div style="font-weight: 950; font-size: 1.15rem; letter-spacing: -0.5px;">Rp {{ number_format($totalClassCash, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Last Payment Card: Indigo Accent -->
    <div class="card bg-silhouette" style="background: var(--grad-indigo); margin-bottom: 0; padding: 1.25rem; height: 140px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);">
        <svg class="pattern" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,50 Q25,0 50,50 T100,50" fill="none" stroke="white" stroke-width="2" />
        </svg>
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="calendar-check" style="width: 16px; color: white;"></i>
            </div>
            <span style="font-size: 0.55rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8;">Terakhir Bayar</span>
        </div>
        <div>
            <div style="font-size: 0.6rem; font-weight: 700; opacity: 0.9; margin-bottom: 0.125rem;">Setoran Terakhir</div>
            <div style="font-weight: 950; font-size: 1.15rem; letter-spacing: -0.5px;">
                {{ $recentTransactions->where('jenis', 'setor')->first() ? \Carbon\Carbon::parse($recentTransactions->where('jenis', 'setor')->first()->tanggal)->format('d M Y') : '-' }}
            </div>
        </div>
    </div>
</div>

<!-- verifikasi note (Minimalist) -->
<div style="background: white; border-radius: 1rem; padding: 1rem; margin-bottom: 2.5rem; border: 1.5px solid var(--border); display: flex; gap: 0.75rem; align-items: center; box-shadow: var(--shadow);">
    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-light); display: flex; align-items: center; justify-content: center;">
        <i data-lucide="shield-check" style="width: 16px; color: var(--primary);"></i>
    </div>
    <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; line-height: 1.4; margin: 0;">
        Seluruh transaksi telah <span class="text-primary">diverifikasi</span> oleh pengurus kelas.
    </p>
</div>

<!-- Transactions Section -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
    <h3 style="font-size: 1.1rem; font-weight: 950; color: var(--text-main); letter-spacing: -0.5px;">{{ $view === 'history' ? 'Riwayat Lengkap' : 'Transaksi Terbaru' }}</h3>
    @if($view !== 'history')
        <a href="{{ route('student.dashboard', ['view' => 'history']) }}" style="font-size: 0.75rem; color: var(--primary); font-weight: 800; text-decoration: none; padding: 0.4rem 0.8rem; background: var(--primary-light); border-radius: 0.5rem;">Lihat Semua</a>
    @else
        <a href="{{ route('student.dashboard') }}" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-decoration: none;">Kembali</a>
    @endif
</div>

<div style="display: flex; flex-direction: column; gap: 0.875rem;">
    @if ($recentTransactions->isEmpty())
        <div style="text-align: center; padding: 4rem 1.5rem; background: white; border-radius: 1.25rem; border: 2px dashed var(--border);">
            <i data-lucide="inbox" style="width: 40px; height: 40px; margin-bottom: 1rem; opacity: 0.1;"></i>
            <h4 style="font-weight: 800; font-size: 0.875rem; color: var(--text-muted);">Belum ada riwayat transaksi</h4>
        </div>
    @else
        @foreach ($recentTransactions as $tx)
            <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1.125rem; margin-bottom: 0; border: 1px solid rgba(0,0,0,0.02);">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: {{ $tx->jenis === 'setor' ? '#ecfdf5' : '#fff1f2' }}; color: {{ $tx->jenis === 'setor' ? '#059669' : '#e11d48' }};">
                        <i data-lucide="{{ $tx->jenis === 'setor' ? 'arrow-up-right' : 'arrow-down-left' }}" style="width: 20px;"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 0.9rem; color: var(--text-main);">{{ $tx->keterangan ?? 'Iuran Kas' }}</div>
                        <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">{{ \Carbon\Carbon::parse($tx->tanggal)->format('d M Y, H:i') }}</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 950; font-size: 1.05rem; color: {{ $tx->jenis === 'setor' ? 'var(--success)' : 'var(--danger)' }};">
                        {{ ($tx->jenis === 'setor' ? '+' : '-') }} {{ number_format($tx->jumlah, 0, ',', '.') }}
                    </div>
                    <div class="status-badge" style="background: var(--bg-main); color: var(--text-muted); font-size: 0.55rem; padding: 0.2rem 0.5rem; margin-top: 0.25rem;">SUCCESS</div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
