@extends('layouts.admin')

@section('title', 'Atur Jadwal Kuliah')

@section('content')
<div style="display: grid; grid-template-columns: 1fr; @media (min-width: 1200px) { grid-template-columns: 350px 1fr; } gap: 2rem;">
    <!-- Form Side -->
    <div>
        <div class="glass-card" style="background: white; position: sticky; top: 1rem;">
            <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary); margin-bottom: 1.5rem;">Tambah Jadwal</h3>
            
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Mata Kuliah</label>
                    <input type="text" name="course_name" required placeholder="Cth: Pemrograman Web">
                </div>
                
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Dosen</label>
                    <input type="text" name="instructor_name" required placeholder="Nama Dosen">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Hari</label>
                        <select name="day" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">SKS</label>
                        <input type="number" name="credit_units" value="2" required min="1">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Mulai</label>
                        <input type="time" name="start_time" required>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Selesai</label>
                        <input type="time" name="end_time" required>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem;">Ruang</label>
                    <input type="text" name="location" placeholder="Cth: D.3.2">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i data-lucide="plus" style="width: 18px;"></i>
                    <span>Simpan Jadwal</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Table Side -->
    <div class="glass-card" style="background: white;">
        <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary); margin-bottom: 2rem;">Daftar Jadwal</h3>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Waktu / Hari</th>
                        <th>Mata Kuliah</th>
                        <th>Ruangan</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $sch)
                    <tr>
                        <td>
                            <div style="font-weight: 800; color: var(--primary-accent);">{{ $sch->day }}</div>
                            <div style="font-size: 0.75rem; color: var(--secondary); font-weight: 600;">{{ \Carbon\Carbon::parse($sch->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($sch->end_time)->format('h:i A') }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--primary);">{{ $sch->course_name }}</div>
                            <div style="font-size: 0.75rem; color: var(--secondary);">{{ $sch->instructor_name }} ({{ $sch->credit_units }} SKS)</div>
                        </td>
                        <td style="font-weight: 600; color: var(--text-muted);">
                            {{ $sch->location ?? '-' }}
                        </td>
                        <td style="text-align: center;">
                            <form action="{{ route('admin.schedules.destroy', $sch->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: var(--danger); cursor: pointer;" onclick="return confirm('Hapus jadwal ini?')">
                                    <i data-lucide="trash-2" style="width: 18px;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 4rem 2rem; opacity: 0.5;">
                            <i data-lucide="calendar" style="width: 48px; height: 48px; margin: 0 auto 1.5rem;"></i>
                            <p style="font-weight: 600;">Belum ada jadwal yang diatur.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
