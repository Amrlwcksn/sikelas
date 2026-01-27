@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
<!-- Sarcastic Payment Alert -->
@if(!$hasPaidThisWeek)
<div class="glass-card" style="margin-bottom: 1.5rem; background: #fff1f2; border: 1px solid #fda4af; padding: 1.25rem; border-radius: 1.25rem; display: flex; align-items: center; gap: 1rem; animation: pulse 2s infinite;">
    <div style="width: 44px; height: 44px; background: #fb7185; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 8px 16px -4px rgba(251, 113, 133, 0.4);">
        <i data-lucide="alert-circle" style="width: 22px; height: 22px;"></i>
    </div>
    <div>
        <div style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #e11d48; margin-bottom: 0.1rem;">Peringatan</div>
        <p style="font-size: 0.8125rem; color: #9f1239; font-weight: 700; line-height: 1.4; margin: 0;">
            {{ $sarcasticMessage }}
        </p>
    </div>
</div>

<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}
</style>
@endif

<!-- Digital Bank Card -->
<!-- Minimalist Digital Card -->
<div class="glass-card" style="margin-bottom: 1.5rem; background: var(--grad-banking); padding: 1.5rem; border-radius: 1.5rem; position: relative; overflow: hidden; color: white; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.3);">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(37, 99, 235, 0.3) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; position: relative; z-index: 10;">
        <div>
            <div style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; color: rgba(255,255,255,0.6); margin-bottom: 0.25rem;">Total Balance</div>
            <div style="font-size: 2rem; font-weight: 900; letter-spacing: -0.05em; line-height: 1;">Rp {{ number_format($myBalance, 0, ',', '.') }}</div>
        </div>
        <div style="width: 36px; height: 36px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.2);">
            <i data-lucide="wallet" style="width: 18px; height: 18px; color: white;"></i>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: flex-end; position: relative; z-index: 10;">
        <div style="display: flex; gap: 0.625rem; align-items: center;">
            <div style="width: 30px; height: 30px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-weight: 950; font-size: 0.75rem;">G</div>
            <div>
                <div style="font-size: 0.8125rem; font-weight: 700;">{{ auth()->user()->name }}</div>
                <div style="font-size: 0.65rem; color: rgba(255,255,255,0.6); font-weight: 500;">{{ auth()->user()->npm }}</div>
            </div>
        </div>
        <div style="font-size: 0.6rem; font-weight: 700; background: rgba(59, 130, 246, 0.3); padding: 0.2rem 0.6rem; border-radius: 2rem; border: 1px solid rgba(59, 130, 246, 0.4); text-transform: uppercase; letter-spacing: 0.1em;">
            Active
        </div>
    </div>
</div>

<!-- Action & Status Cards -->
<div style="display: grid; grid-template-columns: 1fr; gap: 1.25rem; margin-bottom: 2rem;">
    <!-- Class Cash Card (Refined Proportions) -->
    <div class="glass-card" style="padding: 1.5rem; background: white; border: 1px solid rgba(37, 99, 235, 0.1); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(37, 99, 235, 0.05) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; position: relative; z-index: 2;">
            <div>
                <div style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: var(--secondary); margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.4rem;">
                    <span style="width: 6px; height: 6px; background: var(--primary-accent); border-radius: 50%;"></span>
                    Dana Kas Kelas
                </div>
                <div style="font-size: 1.5rem; font-weight: 950; color: var(--primary); tracking: -0.04em;">Rp {{ number_format($totalClassCash, 0, ',', '.') }}</div>
            </div>
            <a href="{{ route('student.pay') }}" class="btn btn-primary" style="height: 46px; padding: 0 1.25rem; border-radius: 0.75rem; font-weight: 850; font-size: 0.875rem; box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.3);">
                <i data-lucide="qr-code" style="width: 18px;"></i>
                <span>Bayar Kas</span>
            </a>
        </div>
        
        <!-- Cash Flow Summary (Compact) -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding: 1rem; background: var(--bg-main); border-radius: 0.875rem; border: 1px solid var(--border); position: relative; z-index: 2;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 32px; height: 32px; background: white; color: var(--success); border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.02);">
                    <i data-lucide="trending-up" style="width: 16px;"></i>
                </div>
                <div>
                    <div style="font-size: 0.55rem; font-weight: 700; color: var(--secondary); text-transform: uppercase;">Masuk</div>
                    <div style="font-size: 0.8125rem; font-weight: 800; color: var(--primary);">Rp{{ number_format($totalSetor, 0, ',', '.') }}</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 32px; height: 32px; background: white; color: var(--danger); border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.02);">
                    <i data-lucide="trending-down" style="width: 16px;"></i>
                </div>
                <div>
                    <div style="font-size: 0.55rem; font-weight: 700; color: var(--secondary); text-transform: uppercase;">Keluar</div>
                    <div style="font-size: 0.8125rem; font-weight: 800; color: var(--primary);">Rp{{ number_format($totalKeluar, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Grid (Proportional to Cash Card) -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <!-- Schedule Card -->
        <a href="{{ route('student.schedules') }}" style="text-decoration: none; display: block;">
            <div class="glass-card" style="padding: 1.25rem; background: white; height: 100%; border: 1px solid rgba(59, 130, 246, 0.1); display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="width: 36px; height: 36px; background: rgba(37, 99, 235, 0.08); color: var(--primary-accent); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="calendar-days" style="width: 20px;"></i>
                </div>
                <div>
                    <div style="font-size: 1.5rem; font-weight: 950; color: var(--primary); line-height: 1;">{{ $todaySchedulesCount }}</div>
                    <div style="font-size: 0.65rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">MK Hari Ini</div>
                </div>
            </div>
        </a>

        <!-- Assignments Card -->
        <a href="{{ route('student.assignments') }}" style="text-decoration: none; display: block;">
            <div class="glass-card" style="padding: 1.25rem; background: white; height: 100%; border: 1px solid rgba(245, 158, 11, 0.1); display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="width: 36px; height: 36px; background: rgba(245, 158, 11, 0.08); color: var(--warning); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="award" style="width: 20px;"></i>
                </div>
                <div>
                    <div style="font-size: 1.5rem; font-weight: 950; color: var(--primary); line-height: 1;">{{ $activeAssignmentsCount }}</div>
                    <div style="font-size: 0.65rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">Tugas Aktif</div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Footer Banner -->
<div class="glass-card" style="background: var(--bg-glass); padding: 1.25rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; border-radius: 1.25rem; border: 1px dashed var(--border);">
    <div style="width: 32px; height: 32px; border-radius: 10px; background: white; color: var(--primary-accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <i data-lucide="shield-check" style="width: 18px;"></i>
    </div>
    <p style="font-size: 0.7rem; color: var(--secondary); font-weight: 700; margin: 0; line-height: 1.4;">
        Semua transaksi tercatat otomatis & diawasi oleh Bendahara.
    </p>
</div>

<!-- Transactions Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0 0.5rem;">
    <h3 style="font-size: 1rem; font-weight: 800; color: var(--primary);">{{ $view === 'history' ? 'Riwayat Transaksi' : 'Aktivitas Terbaru' }}</h3>
    @if($view !== 'history')
        <a href="{{ route('student.dashboard', ['view' => 'history']) }}" style="font-size: 0.75rem; color: var(--primary-accent); font-weight: 700; text-decoration: none;">Lihat Semua</a>
    @else
        <a href="{{ route('student.dashboard') }}" style="font-size: 0.75rem; color: var(--secondary); font-weight: 700; text-decoration: none;">Tutup</a>
    @endif
</div>

<!-- Transactions List -->
<div style="display: flex; flex-direction: column; gap: 0.75rem;">
    @forelse ($recentTransactions as $tx)
        <div class="glass-card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.875rem;">
                <div style="width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: {{ $tx->jenis === 'setor' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $tx->jenis === 'setor' ? 'var(--success)' : 'var(--danger)' }};">
                    <i data-lucide="{{ $tx->jenis === 'setor' ? 'trending-up' : 'trending-down' }}" style="width: 18px;"></i>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 0.875rem; color: var(--primary);">{{ $tx->keterangan ?? 'Setoran Kas' }}</div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.1rem;">
                        <span style="font-size: 0.6rem; font-weight: 800; background: rgba(37, 99, 235, 0.05); color: var(--primary-accent); padding: 0.1rem 0.4rem; border-radius: 0.4rem;">{{ auth()->user()->npm }}</span>
                        <div style="font-size: 0.7rem; color: var(--secondary);">{{ \Carbon\Carbon::parse($tx->tanggal)->translatedFormat('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>
            <div style="text-align: right;">
                <div style="font-weight: 800; font-size: 0.9375rem; color: {{ $tx->jenis === 'setor' ? 'var(--success)' : 'var(--danger)' }};">
                    {{ ($tx->jenis === 'setor' ? '+' : '-') }}Rp {{ number_format($tx->jumlah, 0, ',', '.') }}
                </div>
                <div class="status-badge status-{{ $tx->jenis === 'setor' ? 'success' : 'danger' }}" style="padding: 0.1rem 0.4rem; font-size: 0.55rem; margin-top: 0.25rem; border: none; background: transparent;">
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
<div style="margin-top: 2rem; text-align: center;">
    <a href="{{ route('student.settings') }}" class="btn btn-outline" style="width: 100%; border-radius: 1rem; padding: 1rem;">
        <i data-lucide="settings" style="width: 18px;"></i>
        <span>Pengaturan Akun</span>
    </a>
    <form method="POST" action="{{ route('logout') }}" style="margin-top: 0.875rem;">
        @csrf
        <button type="submit" style="background: none; border: none; color: var(--danger); font-size: 0.8125rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="log-out" style="width: 14px;"></i>
            Keluar Aplikasi
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                title: 'Transaksi Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'Mantap!',
                confirmButtonColor: '#2563eb',
                background: '#ffffff',
                borderRadius: '1.25rem',
                customClass: {
                    title: 'font-plus-jakarta font-bold',
                    confirmButton: 'rounded-xl font-bold px-6 py-3'
                }
            });
        @endif
    });
</script>
@endpush
