@extends('layouts.student')

@section('title', 'Jadwal Kuliah')

@section('content')
<div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
    <a href="{{ route('student.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--secondary); text-decoration: none; font-size: 0.875rem; font-weight: 700;">
        <i data-lucide="chevron-left" style="width: 18px;"></i>
        <span>Kembali</span>
    </a>
    <h2 style="font-size: 1.25rem; font-weight: 900; color: var(--primary); margin: 0;">Jadwal Kuliah</h2>
</div>

@php
    $hariAktif = \Carbon\Carbon::now()->translatedFormat('l');
@endphp

<div style="display: flex; flex-direction: column; gap: 1.25rem;">
    @php
        $groupedSchedules = $schedules->groupBy('day');
        $orderHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    @endphp

    @forelse($orderHari as $hari)
        @if(isset($groupedSchedules[$hari]))
            <div style="margin-top: 0.5rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; padding: 0 0.5rem;">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $hari == $hariAktif ? 'var(--primary-accent)' : 'var(--secondary)' }}; {{ $hari == $hariAktif ? 'box-shadow: 0 0 10px var(--primary-accent);' : '' }}"></div>
                    <span style="font-size: 0.875rem; font-weight: 800; color: {{ $hari == $hariAktif ? 'var(--primary-accent)' : 'var(--primary)' }}; text-transform: uppercase; letter-spacing: 0.1em;">{{ $hari }}</span>
                    @if($hari == $hariAktif)
                        <span style="font-size: 0.65rem; font-weight: 800; background: var(--primary-light); color: var(--primary-accent); padding: 0.125rem 0.625rem; border-radius: 1rem; text-transform: uppercase;">Hari Ini</span>
                    @endif
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($groupedSchedules[$hari] as $sch)
                        <div class="glass-card" style="padding: 1.25rem; background: white; border-left: 4px solid {{ $hari == $hariAktif ? 'var(--primary-accent)' : 'var(--border)' }};">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                                <div>
                                    <div style="font-weight: 800; font-size: 1rem; color: var(--primary);">{{ $sch->course_name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--secondary); margin-top: 0.25rem; font-weight: 600;">{{ $sch->instructor_name }}</div>
                                </div>
                                <div style="background: var(--bg-main); padding: 0.375rem 0.75rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; color: var(--primary);">
                                    {{ $sch->credit_units }} SKS
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 1.5rem; margin-top: 1rem; border-top: 1px dashed var(--border); pt-1rem; padding-top: 0.75rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i data-lucide="clock" style="width: 14px; color: var(--secondary); stroke-width: 3px;"></i>
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ \Carbon\Carbon::parse($sch->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($sch->end_time)->format('h:i A') }}</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i data-lucide="map-pin" style="width: 14px; color: var(--secondary); stroke-width: 3px;"></i>
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ $sch->location ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @empty
        <div style="text-align: center; padding: 4rem 2rem; opacity: 0.5;">
            <i data-lucide="calendar-off" style="width: 48px; height: 48px; margin: 0 auto 1.5rem;"></i>
            <p style="font-weight: 600;">Belum ada jadwal kuliah</p>
        </div>
    @endforelse
</div>
@endsection
