@extends('layouts.student')

@section('title', 'Tugas Perkuliahan')

@section('content')
<div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
    <a href="{{ route('student.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--secondary); text-decoration: none; font-size: 0.875rem; font-weight: 700;">
        <i data-lucide="chevron-left" style="width: 18px;"></i>
        <span>Kembali</span>
    </a>
    <h2 style="font-size: 1.25rem; font-weight: 900; color: var(--primary); margin: 0;">Tugas</h2>
</div>

<!-- Simekar Verification Alert -->
<div class="glass-card" style="background: rgba(245, 158, 11, 0.05); border-left: 4px solid var(--warning); padding: 1.25rem; margin-bottom: 2rem; display: flex; gap: 1rem; align-items: start;">
    <div style="width: 38px; height: 38px; background: rgba(245, 158, 11, 0.1); color: var(--warning); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
        <i data-lucide="info" style="width: 20px;"></i>
    </div>
    <div>
        <h4 style="font-size: 0.9375rem; font-weight: 800; color: #92400e; margin-bottom: 0.25rem;">Verifikasi Simekar</h4>
        <p style="font-size: 0.8125rem; color: #92400e; line-height: 1.5; opacity: 0.8;">
            Tetap lakukan pengecekan secara berkala pada portal <strong>Simekar</strong>. Data tugas yang sebenarnya dan tervalidasi secara resmi ada di sistem Simekar.
        </p>
    </div>
</div>

<div style="display: flex; flex-direction: column; gap: 1rem;">
    @forelse($assignments as $task)
        @php
            $dueDate = \Carbon\Carbon::parse($task->due_date);
            $isOverdue = $dueDate->isPast() && $task->status == 'active';
            $isNear = $dueDate->diffInDays(now()) <= 3 && !$isOverdue && $task->status == 'active';
        @endphp
        <div class="glass-card" style="padding: 1.5rem; background: white; position: relative; overflow: hidden;">
            @if($task->status == 'closed')
                <div style="position: absolute; top: 0; right: 0; padding: 0.5rem 1rem; background: var(--success); color: white; font-size: 0.65rem; font-weight: 800; border-bottom-left-radius: 1rem; text-transform: uppercase;">Selesai</div>
            @elseif($isOverdue)
                <div style="position: absolute; top: 0; right: 0; padding: 0.5rem 1rem; background: var(--danger); color: white; font-size: 0.65rem; font-weight: 800; border-bottom-left-radius: 1rem; text-transform: uppercase;">Terlambat</div>
            @endif

            <div style="margin-bottom: 1rem;">
                <span style="font-size: 0.65rem; font-weight: 800; color: var(--primary-accent); background: var(--primary-light); padding: 0.25rem 0.75rem; border-radius: 2rem; border: 1px solid rgba(37, 99, 235, 0.1); margin-bottom: 0.75rem; display: inline-block;">
                    {{ $task->course->course_name ?? 'Matkul N/A' }}
                </span>
                <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">{{ $task->task_title }}</h3>
                <p style="font-size: 0.875rem; color: var(--secondary); line-height: 1.5;">{{ $task->task_description }}</p>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                <div>
                    <div style="font-size: 0.65rem; font-weight: 700; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Deadline</div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: {{ $isOverdue ? 'var(--danger)' : ($isNear ? 'var(--warning)' : 'var(--primary)') }};">
                        <i data-lucide="clock" style="width: 16px;"></i>
                        <span style="font-weight: 800; font-size: 0.875rem;">{{ $dueDate->translatedFormat('d F Y, h:i A') }}</span>
                    </div>
                </div>
                
                <div style="text-align: right;">
                    @if($task->status == 'active')
                        <div style="font-size: 0.75rem; font-weight: 700; color: {{ $isOverdue ? 'var(--danger)' : ($isNear ? 'var(--warning)' : 'var(--success)') }};">
                            {{ $isOverdue ? 'Sudah Lewat' : $dueDate->diffForHumans() }}
                        </div>
                    @else
                        <div style="display: flex; align-items: center; gap: 0.25rem; color: var(--success); font-weight: 700;">
                            <i data-lucide="check-circle" style="width: 14px;"></i>
                            <span style="font-size: 0.75rem;">Closed</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 4rem 2rem; opacity: 0.5;">
            <i data-lucide="clipboard-check" style="width: 48px; height: 48px; margin: 0 auto 1.5rem;"></i>
            <p style="font-weight: 600;">Tidak ada tugas saat ini</p>
            <p style="font-size: 0.8125rem;">Nikmati waktu luangmu!</p>
        </div>
    @endforelse
</div>
@endsection
