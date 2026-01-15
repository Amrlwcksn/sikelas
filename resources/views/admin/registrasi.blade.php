@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa Baru')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Registrasi Anggota Baru</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Daftarkan mahasiswa baru ke dalam ekosistem Sikelas Digital.</p>
</div>

<div style="max-width: 680px; margin: 2rem 0;">
    <div class="glass-card" style="background: white; border-radius: 2rem; padding: 3rem;">
        <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 3rem; border-bottom: 1px solid var(--border); padding-bottom: 2rem;">
            <div style="width: 56px; height: 56px; background: var(--primary-light); color: var(--primary-accent); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="user-plus" style="width: 28px; height: 28px;"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black">Formulir Data</h3>
                <p style="color: var(--text-muted); font-weight: 500;">Pastikan data yang dimasukkan sesuai dengan identitas resmi.</p>
            </div>
        </div>
        
        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.05); color: var(--danger); padding: 1.5rem; border-radius: 1.25rem; border: 1px solid rgba(239, 68, 68, 0.1); margin-bottom: 2.5rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <i data-lucide="alert-octagon" style="width: 20px;"></i>
                    <span style="font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">Verifikasi Gagal</span>
                </div>
                <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.875rem; font-weight: 600;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.registrasi.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 2.5rem;">
            @csrf
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--secondary); margin-bottom: 0.75rem;">
                    <i data-lucide="fingerprint" style="width: 14px;"></i> Nomor Pokok Mahasiswa (NPM)
                </label>
                <div class="relative">
                    <input type="number" name="npm" required placeholder="Contoh: 224400xx" minLength="8" value="{{ old('npm') }}" 
                        style="font-size: 1.25rem; font-weight: 800; letter-spacing: 0.1em; padding: 1.25rem 1.5rem;">
                </div>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.75rem; font-weight: 500;">Digunakan sebagai identitas akses tunggal (Login ID).</p>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--secondary); margin-bottom: 0.75rem;">
                    <i data-lucide="user" style="width: 14px;"></i> Nama Lengkap Mahasiswa
                </label>
                <input type="text" name="name" required placeholder="Masukkan Nama Lengkap Sesuai KTM" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--secondary); margin-bottom: 0.75rem;">
                    <i data-lucide="key-round" style="width: 14px;"></i> Kata Sandi Akses
                </label>
                <div style="position: relative;">
                    <input type="password" name="password" required value="password123" style="background: var(--bg-main);">
                </div>
                <div style="background: var(--bg-main); padding: 1rem 1.25rem; border-radius: 1rem; margin-top: 1rem; border: 1px dashed var(--border); display: flex; align-items: flex-start; gap: 1rem;">
                    <i data-lucide="info" style="width: 18px; color: var(--primary-accent); margin-top: 2px;"></i>
                    <p style="font-size: 0.8125rem; color: var(--text-muted); font-weight: 500; line-height: 1.5;">Sandi otomatis disetel ke <span style="color: var(--primary-accent); font-weight: 800;">password123</span>. Anggota baru sangat disarankan untuk mengubahnya segera.</p>
                </div>
            </div>

            <div style="display: flex; gap: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                <button type="submit" class="btn btn-primary" style="flex: 2; padding: 1.25rem; border-radius: 1rem; font-size: 1rem;">
                    <i data-lucide="check-circle-2"></i> Konfirmasi Pendaftaran
                </button>
                <a href="{{ route('admin.students') }}" class="btn" style="background: var(--bg-main); color: var(--text-muted); flex: 1; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                    Batalkan
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
