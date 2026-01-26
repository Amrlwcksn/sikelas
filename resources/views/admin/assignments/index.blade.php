@extends('layouts.admin')

@section('title', 'Kelola Tugas Mahasiswa')

@section('content')
<div style="display: grid; grid-template-columns: 1fr; @media (min-width: 1200px) { grid-template-columns: 350px 1fr; } gap: 2rem;">
    <!-- Form Side -->
    <div>
        <div class="glass-card" style="background: white; position: sticky; top: 1rem;">
            <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary); margin-bottom: 1.5rem;">Tugas Baru</h3>
            
            <form action="{{ route('admin.assignments.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Pilih Mata Kuliah</label>
                    <select name="academic_course_id" required>
                        <option value="">-- Pilih Matkul --</option>
                        @foreach($academic_courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Judul Tugas</label>
                    <input type="text" name="task_title" required placeholder="Cth: Laporan Praktikum 1">
                </div>
                
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Deadline (Batas Waktu)</label>
                    <input type="datetime-local" name="due_date" required>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Keterangan / Link</label>
                    <textarea name="task_description" rows="3" placeholder="Opsional: Keterangan tambahan atau link submit"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i data-lucide="megaphone" style="width: 18px;"></i>
                    <span>Umumkan Tugas</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Table Side -->
    <div class="glass-card" style="background: white;">
        <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary); margin-bottom: 2rem;">Daftar Tugas Aktif</h3>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tugas / Matkul</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $task)
                    <tr>
                        <td>
                            <div style="font-weight: 800; color: var(--primary);">{{ $task->task_title }}</div>
                            <div style="font-size: 0.75rem; color: var(--primary-accent); font-weight: 700; margin-top: 0.125rem;">{{ $task->course->course_name ?? 'Matkul N/A' }}</div>
                        </td>
                        <td>
                            <div style="font-size: 0.875rem; font-weight: 700; color: var(--text-muted);">
                                {{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('d M Y, h:i A') }}
                            </div>
                            <div style="font-size: 0.7rem; color: var(--secondary);">{{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }}</div>
                        </td>
                        <td>
                            <form action="{{ route('admin.assignments.update', $task->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" style="font-size: 0.7rem; padding: 0.25rem 0.5rem; border-radius: 0.5rem; border: 1px solid var(--border); {{ $task->status === 'closed' ? 'background: #f1f5f9; color: #64748b;' : 'background: #f0fdf4; color: #166534;' }}">
                                    <option value="active" {{ $task->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="closed" {{ $task->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </form>
                        </td>
                        <td style="text-align: center;">
                            <form action="{{ route('admin.assignments.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: var(--danger); cursor: pointer;" onclick="return confirm('Hapus pengumuman tugas ini?')">
                                    <i data-lucide="trash-2" style="width: 18px;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 4rem 2rem; opacity: 0.5;">
                            <i data-lucide="clipboard-list" style="width: 48px; height: 48px; margin: 0 auto 1.5rem;"></i>
                            <p style="font-weight: 600;">Belum ada tugas yang diinput.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
