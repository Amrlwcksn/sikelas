@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Data Mahasiswa</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Daftar seluruh anggota kelas Sikelas.</p>
</div>

<div class="table-container">
    <div style="padding: 2rem; border-bottom: 2px solid var(--bg-main); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h3 class="text-xl font-bold">Anggota Kelas ({{ count($students) }})</h3>
        <div style="position: relative; max-width: 320px; width: 100%;">
            <i data-lucide="search" style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-30%); width: 18px; color: var(--text-muted);"></i>
            <input type="text" id="member_search" placeholder="Cari Nama atau NPM..." style="padding-left: 3.5rem; margin-top: 0;">
        </div>
    </div>
    
    <table id="member_table">
        <thead>
            <tr>
                <th style="width: 80px;">No</th>
                <th style="width: 250px;">NPM</th>
                <th>Nama Lengkap</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $index => $s)
                <tr>
                    <td style="color: var(--text-muted); font-weight: 700;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 32px; height: 32px; background: var(--primary-light); color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.75rem;">
                                {{ substr($s->npm, -2) }}
                            </div>
                            <span style="font-family: inherit; font-weight: 700; color: var(--primary);">{{ $s->npm }}</span>
                        </div>
                    </td>
                    <td style="font-weight: 700; color: var(--text-main);">{{ $s->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" align="center" style="padding: 5rem; color: var(--text-muted);">
                        <i data-lucide="info" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                        <p style="font-weight: 600;">Belum ada data anggota kelas terdaftar.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('member_search').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#member_table tbody tr');
    
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>
@endpush
