@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Ringkasan Kelas</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Pantau kondisi keuangan dan anggota kelas Anda hari ini.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <span class="stat-label">Total Saldo Kas</span>
                <div class="stat-value">Rp {{ number_format($totalClassCash, 0, ',', '.') }}</div>
            </div>
            <div class="stat-icon" style="background: var(--primary-light); color: var(--primary);">
                <i data-lucide="wallet"></i>
            </div>
        </div>
        <div class="stat-sub" style="color: var(--success);">
            <i data-lucide="trending-up" style="width: 14px; height: 14px; display: inline; vertical-align: middle;"></i>
            Aktif & Terkendali
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div>
                <span class="stat-label">Total Mahasiswa</span>
                <div class="stat-value">{{ $totalStudents }}</div>
            </div>
            <div class="stat-icon" style="background: #fffbeb; color: var(--warning);">
                <i data-lucide="users"></i>
            </div>
        </div>
        <div class="stat-sub text-muted">
            Mahasiswa Terdaftar
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div>
                <span class="stat-label">Akun Keuangan</span>
                <div class="stat-value">{{ $totalAccounts }} Akun</div>
            </div>
            <div class="stat-icon" style="background: #ecfdf5; color: var(--success);">
                <i data-lucide="shield-check"></i>
            </div>
        </div>
        <div class="stat-sub" style="color: var(--success);">
            Semua Tersinkron
        </div>
    </div>
</div>

<div class="card">
    <div class="mb-8">
        <h3 class="text-xl font-bold">Aksi Cepat</h3>
        <p class="text-text-muted text-sm">Akses fitur utama dalam satu klik.</p>
    </div>
    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.transactions') }}" class="btn btn-primary">
            <i data-lucide="plus-circle"></i>
            Input Transaksi Baru
        </a>
        <a href="{{ route('admin.registrasi') }}" class="btn" style="background: var(--text-main); color: white;">
            <i data-lucide="user-plus"></i>
            Tambah Mahasiswa
        </a>
    </div>
</div>
@endsection
