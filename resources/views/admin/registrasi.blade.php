@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa Baru')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Tambah Mahasiswa Baru</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Daftarkan anggota kelas baru ke ekosistem Sikelas Digital.</p>
</div>

<div style="max-width: 650px; margin: 3rem auto;">
    <div class="card">
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="width: 60px; height: 60px; background: var(--primary-light); color: var(--primary); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <i data-lucide="user-plus" style="width: 32px; height: 32px;"></i>
            </div>
            <h3 class="text-2xl font-black">Form Pendaftaran</h3>
            <p style="color: var(--text-muted); font-weight: 600; margin-top: 0.5rem;">Lengkapi data mahasiswa di bawah ini.</p>
        </div>
        
        @if ($errors->any())
            <div style="background: #fff1f2; color: #be123c; padding: 1.5rem; border-radius: 1.25rem; border: 2px solid #fecdd3; margin-bottom: 2.5rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                    <i data-lucide="alert-circle" style="width: 20px;"></i>
                    <span style="font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">Pendaftaran Gagal</span>
                </div>
                <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.875rem; font-weight: 600;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.registrasi.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 2rem;">
            @csrf
            <div>
                <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                    <i data-lucide="id-card" style="width: 16px;"></i> NPM (8 Digit)
                </label>
                <input type="number" name="npm" required placeholder="Contoh: 224400xx" minLength="8" value="{{ old('npm') }}" style="font-size: 1.25rem; font-weight: 800; letter-spacing: 2px;">
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.75rem; font-weight: 600;">NPM akan digunakan sebagai ID login utama mahasiswa.</p>
            </div>

            <div>
                <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                    <i data-lucide="user-check" style="width: 16px;"></i> Nama Lengkap
                </label>
                <input type="text" name="name" required placeholder="Masukkan nama sesuai KTM" value="{{ old('name') }}">
            </div>

            <div>
                <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                    <i data-lucide="lock" style="width: 16px;"></i> Kata Sandi
                </label>
                <input type="password" name="password" required value="password123">
                <div style="background: var(--bg-main); padding: 1.25rem; border-radius: 1rem; margin-top: 1.25rem; border: 2px dashed var(--border); display: flex; align-items: flex-start; gap: 1rem;">
                    <i data-lucide="shield-alert" style="width: 20px; color: var(--warning); flex-shrink: 0;"></i>
                    <p style="font-size: 0.8125rem; color: var(--text-muted); font-weight: 600; line-height: 1.4;">Sandi default diset ke <span style="color: var(--primary); font-weight: 800;">password123</span>. Mahasiswa wajib menggantinya setelah login pertama.</p>
                </div>
            </div>

            <div style="display: flex; gap: 1.25rem; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 2;">
                    <i data-lucide="check-circle"></i> Daftarkan Mahasiswa
                </button>
                <a href="{{ route('admin.students') }}" class="btn" style="background: var(--bg-main); color: var(--text-muted); flex: 1;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
