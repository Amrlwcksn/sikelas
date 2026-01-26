@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">
        @if(auth()->user()->role === 'bendahara')
            Ringkasan Keuangan Kelas
        @else
            Manajemen Akademik Kelas
        @endif
    </h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Selamat datang kembali, {{ auth()->user()->name }}. Monitor tugas Anda secara real-time.</p>
</div>

<div class="stats-grid">
    @if(auth()->user()->role === 'bendahara')
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
                    <span>Tersedia di Brankas</span>
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
                <div class="stat-value">{{ $totalStudents }} <span style="font-size: 1.25rem; font-weight: 600; color: var(--text-muted);">Anggota</span></div>
                <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500; margin-top: 0.5rem;">
                    Mahasiswa Terdaftar
                </div>
            </div>
        </div>
    @endif

    @if(auth()->user()->role === 'sekertaris')
        <div class="glass-card stat-card" style="border-left: 4px solid var(--success);">
            <div class="stat-header">
                <span class="stat-label">Jadwal Kuliah</span>
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                    <i data-lucide="calendar"></i>
                </div>
            </div>
            <div>
                <div class="stat-value">{{ $totalSchedules }} <span style="font-size: 1.25rem; font-weight: 600; color: var(--text-muted);">Mata Kuliah</span></div>
                <div style="font-size: 0.875rem; color: var(--success); font-weight: 600; margin-top: 0.5rem;">
                    Terdaftar di Kurikulum
                </div>
            </div>
        </div>

        <div class="glass-card stat-card" style="border-left: 4px solid var(--primary-accent);">
            <div class="stat-header">
                <span class="stat-label">Tugas Aktif</span>
                <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-accent);">
                    <i data-lucide="clipboard-list"></i>
                </div>
            </div>
            <div>
                <div class="stat-value">{{ $activeAssignments }} <span style="font-size: 1.25rem; font-weight: 600; color: var(--text-muted);">Pending</span></div>
                <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500; margin-top: 0.5rem;">
                    Belum Ditutup
                </div>
            </div>
        </div>
    @endif
</div>

<div class="glass-card" style="background: white;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
        <div>
            <h3 class="text-xl font-bold">Aksi Cepat</h3>
            <p style="color: var(--text-muted); font-size: 0.875rem;">Akses fitur utama pengelolaan kelas dalam satu klik.</p>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
        @if(auth()->user()->role === 'bendahara')
            <a href="{{ route('admin.transactions') }}" class="btn btn-primary" style="height: auto; padding: 1.5rem; flex-direction: column; align-items: flex-start; border-radius: 1.25rem;">
                <div style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <i data-lucide="plus-circle" style="width: 24px; height: 24px;"></i>
                </div>
                <div style="text-align: left;">
                    <div style="font-size: 1rem; font-weight: 700;">Input Transaksi</div>
                    <div style="font-size: 0.75rem; font-weight: 400; opacity: 0.8; margin-top: 0.25rem;">Catat pemasukan manual</div>
                </div>
            </a>

            <a href="{{ route('admin.payments.validasi') }}" class="btn" style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; height: auto; padding: 1.5rem; flex-direction: column; align-items: flex-start; border-radius: 1.25rem;">
                <div style="width: 40px; height: 40px; background: #dcfce7; color: #15803d; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <i data-lucide="shield-check" style="width: 24px; height: 24px;"></i>
                </div>
                <div style="text-align: left;">
                    <div style="font-size: 1rem; font-weight: 700;">Validasi QRIS</div>
                    <div style="font-size: 0.75rem; font-weight: 400; opacity: 0.8; margin-top: 0.25rem;">Konfirmasi pembayaran</div>
                </div>
            </a>
        @endif

        @if(auth()->user()->role === 'sekertaris')
            <a href="{{ route('admin.schedules.index') }}" class="btn btn-primary" style="height: auto; padding: 1.5rem; flex-direction: column; align-items: flex-start; border-radius: 1.25rem;">
                <div style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <i data-lucide="calendar" style="width: 24px; height: 24px;"></i>
                </div>
                <div style="text-align: left;">
                    <div style="font-size: 1rem; font-weight: 700;">Atur Jadwal</div>
                    <div style="font-size: 0.75rem; font-weight: 400; opacity: 0.8; margin-top: 0.25rem;">Update waktu kuliah</div>
                </div>
            </a>

            <a href="{{ route('admin.assignments.index') }}" class="btn" style="background: #fffbeb; border: 1px solid #fde68a; color: #92400e; height: auto; padding: 1.5rem; flex-direction: column; align-items: flex-start; border-radius: 1.25rem;">
                <div style="width: 40px; height: 40px; background: #fef3c7; color: #b45309; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <i data-lucide="clipboard-list" style="width: 24px; height: 24px;"></i>
                </div>
                <div style="text-align: left;">
                    <div style="font-size: 1rem; font-weight: 700;">Atur Tugas</div>
                    <div style="font-size: 0.75rem; font-weight: 400; opacity: 0.8; margin-top: 0.25rem;">Input deadline & info</div>
                </div>
            </a>
        @endif

        <a href="{{ route('admin.students') }}" class="btn" style="background: #f8fafc; border: 1px solid var(--border); color: var(--primary); height: auto; padding: 1.5rem; flex-direction: column; align-items: flex-start; border-radius: 1.25rem;">
            <div style="width: 40px; height: 40px; background: var(--primary-light); color: var(--primary-accent); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <i data-lucide="users" style="width: 24px; height: 24px;"></i>
            </div>
            <div style="text-align: left;">
                <div style="font-size: 1rem; font-weight: 700;">Data Mahasiswa</div>
                <div style="font-size: 0.75rem; font-weight: 400; color: var(--text-muted); margin-top: 0.25rem;">Lihat daftar anggota</div>
            </div>
        </a>
    </div>
</div>

@if(auth()->user()->role === 'sekertaris')
    <div class="mb-8" style="margin-top: 3rem;">
        <h2 class="text-2xl font-black">Matrix Monitoring Akademik</h2>
        <p style="color: var(--text-muted);">Pantau seluruh kesibukan kelas dalam satu tampilan grid mingguan.</p>
    </div>

    <!-- Academic Matrix Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
        <!-- Left: Weekly Schedule Matrix -->
        <div class="glass-card" style="background: white; grid-column: span 2;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border);">
                <h3 style="font-size: 1.125rem; font-weight: 800; display: flex; align-items: center; gap: 0.75rem;">
                    <i data-lucide="layout-grid" style="color: var(--primary-accent);"></i>
                    Jadwal Mingguan
                </h3>
                <span style="font-size: 0.75rem; font-weight: 800; color: var(--secondary); text-transform: uppercase;">Senin - Minggu</span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; @media (max-width: 768px) { grid-template-columns: 1fr; }">
                @php $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp
                @foreach($days as $day)
                    <div style="padding: 1rem; border-radius: 1rem; background: {{ $todayIndo == $day ? 'var(--primary-light)' : '#f8fafc' }}; border: 1px solid {{ $todayIndo == $day ? 'rgba(37, 99, 235, 0.2)' : 'var(--border)' }};">
                        <div style="font-size: 0.8125rem; font-weight: 900; color: {{ $todayIndo == $day ? 'var(--primary-accent)' : 'var(--secondary)' }}; text-transform: uppercase; margin-bottom: 1rem; display: flex; justify-content: space-between;">
                            {{ $day }}
                            @if($todayIndo == $day)
                                <span style="font-size: 0.6rem; background: var(--primary-accent); color: white; padding: 0.1rem 0.4rem; border-radius: 0.5rem;">Hari Ini</span>
                            @endif
                        </div>
                        
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            @forelse($schedulesByDay->get($day, []) as $s)
                                <div style="background: white; padding: 0.75rem; border-radius: 0.75rem; border: 1px solid var(--border); shadow: var(--shadow-soft);">
                                    <div style="font-size: 0.875rem; font-weight: 800; color: var(--primary); line-height: 1.3;">{{ $s->course_name }}</div>
                                    <div style="font-size: 0.7rem; color: var(--secondary); margin-top: 0.375rem; font-weight: 600; display: flex; align-items: center; gap: 0.375rem;">
                                        <i data-lucide="clock" style="width: 10px;"></i>
                                        {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }}
                                    </div>
                                </div>
                            @empty 
                                <div style="height: 60px; display: flex; align-items: center; justify-content: center; border: 1px dashed var(--border); border-radius: 0.75rem; opacity: 0.4;">
                                    <span style="font-size: 0.7rem; font-weight: 700;">Kosong</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Tasks Matrix/Priority -->
        <div class="glass-card" style="background: white;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border);">
                <h3 style="font-size: 1.125rem; font-weight: 800; display: flex; align-items: center; gap: 0.75rem;">
                    <i data-lucide="list-todo" style="color: var(--warning);"></i>
                    Deadline Terdekat
                </h3>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($upcomingAssignments as $a)
                    @php 
                        $due = \Carbon\Carbon::parse($a->due_date);
                        $diff = now()->diffInDays($due, false);
                        $type = $diff <= 2 ? 'danger' : ($diff <= 5 ? 'warning' : 'primary-accent');
                    @endphp
                    <div style="display: flex; gap: 1rem; align-items: center; padding: 1rem; border-radius: 1rem; background: #f8fafc; border-left: 4px solid var(--{{ $type }});">
                        <div style="flex: 1;">
                            <div style="font-size: 0.9375rem; font-weight: 800; color: var(--primary);">{{ $a->task_title }}</div>
                            <div style="font-size: 0.75rem; color: var(--secondary); margin-top: 0.25rem;">{{ $a->course->course_name ?? 'Matkul N/A' }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 0.65rem; font-weight: 800; color: var(--{{ $type }}); text-transform: uppercase;">
                                {{ $diff < 0 ? 'Overdue' : ($diff == 0 ? 'Sore Ini' : ($diff == 1 ? 'Besok' : $diff . ' Hari lagi')) }}
                            </div>
                            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ $due->format('d/m') }}</div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 3rem 1rem; opacity: 0.5;">
                        <i data-lucide="check-circle-2" style="width: 32px; height: 32px; margin: 0 auto 1.25rem;"></i>
                        <p style="font-weight: 700; font-size: 0.875rem;">Tidak ada tugas aktif</p>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('admin.assignments.index') }}" class="btn btn-outline" style="width: 100%; margin-top: 2rem; border-radius: 1rem; font-size: 0.8125rem;">
                <span>Kelola Semua Tugas</span>
                <i data-lucide="chevron-right" style="width: 14px;"></i>
            </a>
        </div>
    </div>
@endif
@endsection
