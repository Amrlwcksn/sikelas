@extends('layouts.admin')

@section('title', 'Informasi Profil')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Account Settings</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Manage your administrative credentials and security.</p>
</div>

<div style="max-width: 800px; display: flex; flex-direction: column; gap: 3rem;">
    <!-- Profile Info -->
    <div class="glass-card" style="background: white; padding: 2.5rem; border-radius: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
            <div style="width: 44px; height: 44px; background: var(--primary-light); color: var(--primary-accent); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="user-cog" style="width: 20px;"></i>
            </div>
            <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary);">Update Official Identity</h3>
        </div>
        <div style="max-width: 600px;">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- Password Update -->
    <div class="glass-card" style="background: white; padding: 2.5rem; border-radius: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
            <div style="width: 44px; height: 44px; background: var(--primary-light); color: var(--primary-accent); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="shield-lock" style="width: 20px;"></i>
            </div>
            <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary);">Security Authorization</h3>
        </div>
        <div style="max-width: 600px;">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Delete Account (Optional but present) -->
    <div class="glass-card" style="background: white; padding: 2.5rem; border-radius: 2rem; border: 1px solid rgba(239, 68, 68, 0.1);">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
            <div style="width: 44px; height: 44px; background: rgba(239, 68, 68, 0.05); color: var(--danger); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="user-x" style="width: 20px;"></i>
            </div>
            <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--danger);">Terminate Account</h3>
        </div>
        <div style="max-width: 600px;">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
