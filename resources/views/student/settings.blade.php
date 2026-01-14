@extends('layouts.student')

@section('title', 'Pengaturan')

@section('content')
<div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 2.5rem;">
    <a href="{{ route('student.dashboard') }}" class="btn" style="width: 44px; height: 44px; padding: 0; background: white; color: var(--text-main); box-shadow: var(--shadow); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
        <i data-lucide="chevron-left" style="width: 20px;"></i>
    </a>
    <div>
        <h2 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 1.5rem; color: var(--text-main); letter-spacing: -0.5px;">Pengaturan Akun</h2>
        <p style="font-size: 0.8125rem; color: var(--text-muted); font-weight: 600;">Kelola keamanan akun Anda</p>
    </div>
</div>

@if(session('success'))
    <div style="background: #ecfdf5; border: 2px solid #10b981; color: #047857; padding: 1.25rem; border-radius: 1.25rem; margin-bottom: 2.5rem; font-size: 0.875rem; font-weight: 700; display: flex; align-items: center; gap: 0.875rem;">
        <i data-lucide="check-circle" style="width: 20px;"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background: #fff1f2; border: 2px solid #f43f5e; color: #be123c; padding: 1.25rem; border-radius: 1.25rem; margin-bottom: 2.5rem; font-size: 0.875rem; font-weight: 700;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            <i data-lucide="alert-circle" style="width: 20px;"></i>
            <span>Mohon periksa kembali:</span>
        </div>
        <ul style="margin: 0; padding-left: 2rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card" style="padding: 2.5rem; border: none; box-shadow: var(--shadow); margin-top: 1rem;">
    <div style="display: flex; align-items: center; gap: 0.875rem; margin-bottom: 2rem;">
        <div style="width: 40px; height: 40px; background: var(--primary-light); color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="lock" style="width: 20px;"></i>
        </div>
        <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main);">Ganti Password</h3>
    </div>

    <form action="{{ route('student.update-password') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.75rem;">
        @csrf
        <div class="form-group">
            <label>Password Saat Ini</label>
            <input type="password" name="current_password" required placeholder="••••••••">
        </div>
        
        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="new_password" required placeholder="Min. 8 Karakter">
        </div>

        <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" required placeholder="Ulangi Password Baru">
        </div>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn-primary" style="width: 100%; padding: 1.25rem; border-radius: 16px; font-weight: 900; font-size: 1rem;">
                Simpan Perubahan <i data-lucide="save" style="width: 18px; margin-left: 8px;"></i>
            </button>
        </div>
    </form>
</div>

<div style="margin-top: 3rem; text-align: center; opacity: 0.5;">
    <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
        ID Pengguna: {{ auth()->user()->npm }}
    </p>
</div>
@endsection
