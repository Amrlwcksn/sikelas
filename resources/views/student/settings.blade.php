@extends('layouts.student')

@section('title', 'Keamanan Akun')

@section('content')
<!-- Header Navigation -->
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
    <a href="{{ route('student.dashboard') }}" style="width: 48px; height: 48px; background: white; color: var(--primary); border: 1px solid var(--border); border-radius: 14px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: var(--shadow-soft);">
        <i data-lucide="arrow-left" style="width: 20px;"></i>
    </a>
    <div>
        <h2 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 900; font-size: 1.25rem; color: var(--primary); letter-spacing: -0.5px;">Security Center</h2>
        <p style="font-size: 0.8125rem; color: var(--secondary); font-weight: 600;">Authorized personal settings</p>
    </div>
</div>

@if(session('success'))
    <div class="glass-card" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); color: var(--success); padding: 1.25rem; border-radius: 1.25rem; margin-bottom: 2.5rem; font-size: 0.875rem; font-weight: 700; display: flex; align-items: center; gap: 0.875rem;">
        <i data-lucide="shield-check" style="width: 20px;"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="glass-card" style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2); color: var(--danger); padding: 1.25rem; border-radius: 1.25rem; margin-bottom: 2.5rem; font-size: 0.875rem; font-weight: 700;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
            <i data-lucide="alert-octagon" style="width: 20px;"></i>
            <span style="text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem;">Action Required</span>
        </div>
        <ul style="margin: 0; padding-left: 1.5rem; font-weight: 500;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Password Management -->
<div class="glass-card" style="background: white; padding: 2.5rem; border-radius: 2rem;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
        <div style="width: 44px; height: 44px; background: var(--primary-light); color: var(--primary-accent); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="lock" style="width: 20px;"></i>
        </div>
        <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary);">Update PIN / Password</h3>
    </div>

    <form action="{{ route('student.update-password') }}" method="POST" style="display: flex; flex-direction: column; gap: 2rem;">
        @csrf
        <div class="form-group">
            <label style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Old PIN / Password</label>
            <input type="password" name="current_password" required placeholder="••••••••" style="background: var(--bg-main); font-weight: 800; letter-spacing: 0.2em;">
        </div>
        
        <div class="form-group">
            <label style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">New PIN / Password</label>
            <input type="password" name="new_password" required placeholder="Min. 8 characters" style="background: var(--bg-main); font-weight: 800; letter-spacing: 0.2em;">
        </div>

        <div class="form-group">
            <label style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Confirm New PIN</label>
            <input type="password" name="new_password_confirmation" required placeholder="Repeat new password" style="background: var(--bg-main); font-weight: 800; letter-spacing: 0.2em;">
        </div>

        <div style="margin-top: 1rem; border-top: 1px solid var(--border); padding-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.25rem; border-radius: 1.25rem; font-weight: 800;">
                <i data-lucide="check-circle-2"></i> Authorized Change
            </button>
        </div>
    </form>
</div>

<!-- Extra Info -->
<div style="margin-top: 3rem; text-align: center;">
    <p style="font-size: 0.65rem; color: var(--secondary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; opacity: 0.5;">
        Session Identity: {{ auth()->user()->npm }}
    </p>
    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem; font-weight: 500;">
        Sikelas Ecosystem v2.0 - Secured by Genite
    </p>
</div>
@endsection
