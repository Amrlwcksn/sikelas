@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Ringkasan Keuangan Kelas</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Pantau kondisi keuangan dan anggota kelas Anda secara real-time.</p>
</div>

<div class="stats-grid">
    <div class="glass-card stat-card" style="border-left: 4px solid var(--primary-accent);">
        <div class="stat-header">
            <span class="stat-label">Total Saldo Kas</span>
            <div class="stat-icon">
                <i data-lucide="wallet"></i>
            </div>
        </div>
        <div>
            <div class="stat-value">Rp {{ number_format($totalClassCash, 0, ',', '.') }}</div>
            <div style="font-size: 0.875rem; color: var(--success); font-weight: 600; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                <i data-lucide="trending-up" style="width: 14px; height: 14px;"></i>
                <span>Aktif & Terkendali</span>
            </div>
        </div>
    </div>

    <div class="glass-card stat-card" style="border-left: 4px solid #f59e0b;">
        <div class="stat-header">
            <span class="stat-label">Total Mahasiswa</span>
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i data-lucide="users-2"></i>
            </div>
        </div>
        <div>
            <div class="stat-value">{{ $totalStudents }}</div>
            <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500; margin-top: 0.5rem;">
                Mahasiswa Terdaftar
            </div>
        </div>
    </div>

    <div class="glass-card stat-card" style="border-left: 4px solid var(--success);">
        <div class="stat-header">
            <span class="stat-label">Akun Keuangan</span>
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                <i data-lucide="shield-check"></i>
            </div>
        </div>
        <div>
            <div class="stat-value">{{ $totalAccounts }} <span style="font-size: 1.25rem; font-weight: 600; color: var(--text-muted);">Akun</span></div>
            <div style="font-size: 0.875rem; color: var(--success); font-weight: 600; margin-top: 0.5rem;">
                Semua Tersinkron
            </div>
        </div>
    </div>
</div>

<div class="glass-card" style="background: white;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
        <div>
            <h3 class="text-xl font-bold">Aksi Cepat</h3>
            <p style="color: var(--text-muted); font-size: 0.875rem;">Akses fitur utama perbankan kelas dalam satu klik.</p>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
        <a href="{{ route('admin.transactions') }}" class="btn btn-primary" style="height: auto; padding: 1.5rem; flex-direction: column; align-items: flex-start; border-radius: 1.25rem;">
            <div style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <i data-lucide="plus-circle" style="width: 24px; height: 24px;"></i>
            </div>
            <div style="text-align: left;">
                <div style="font-size: 1rem; font-weight: 700;">Input Transaksi</div>
                <div style="font-size: 0.75rem; font-weight: 400; opacity: 0.8; margin-top: 0.25rem;">Catat pemasukan/pengeluaran</div>
            </div>
        </a>

        <a href="{{ route('admin.registrasi') }}" class="btn" style="background: #f8fafc; border: 1px solid var(--border); color: var(--primary); height: auto; padding: 1.5rem; flex-direction: column; align-items: flex-start; border-radius: 1.25rem;">
            <div style="width: 40px; height: 40px; background: var(--primary-light); color: var(--primary-accent); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <i data-lucide="user-plus" style="width: 24px; height: 24px;"></i>
            </div>
            <div style="text-align: left;">
                <div style="font-size: 1rem; font-weight: 700;">Tambah Mahasiswa</div>
                <div style="font-size: 0.75rem; font-weight: 400; color: var(--text-muted); margin-top: 0.25rem;">Pendaftaran anggota baru</div>
            </div>
        </a>

        <a href="{{ route('admin.rekap') }}" class="btn" style="background: #f8fafc; border: 1px solid var(--border); color: var(--primary); height: auto; padding: 1.5rem; flex-direction: column; align-items: flex-start; border-radius: 1.25rem;">
            <div style="width: 40px; height: 40px; background: #fff1f2; color: #e11d48; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <i data-lucide="file-text" style="width: 24px; height: 24px;"></i>
            </div>
            <div style="text-align: left;">
                <div style="font-size: 1rem; font-weight: 700;">Rekapitulasi</div>
                <div style="font-size: 0.75rem; font-weight: 400; color: var(--text-muted); margin-top: 0.25rem;">Lihat laporan lengkap</div>
            </div>
        </a>
    </div>
</div>
@endsection
