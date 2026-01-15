@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Manajemen Data Anggota</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Daftar lengkap nasabah perbankan ekosistem Sikelas.</p>
</div>

<div class="glass-card" style="background: white; padding: 0; overflow: hidden;">
    <div style="padding: 2rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h3 class="text-xl font-bold">Nasabah Aktif <span style="font-size: 0.875rem; color: var(--secondary); margin-left: 0.5rem; font-weight: 500;">({{ count($students) }} Mahasiswa)</span></h3>
        <div style="position: relative; max-width: 320px; width: 100%;">
            <i data-lucide="search" style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); width: 16px; color: var(--text-muted);"></i>
            <input type="text" id="member_search" placeholder="Cari Nama / NPM..." style="padding-left: 3.25rem; background: var(--bg-main); border-radius: 2rem;">
        </div>
    </div>
    
    <div style="overflow-x: auto;">
        <table id="member_table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 1.25rem 2rem; background: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: var(--secondary); font-weight: 800; border-bottom: 1px solid var(--border); text-align: left; width: 80px;">No</th>
                    <th style="padding: 1.25rem 2rem; background: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: var(--secondary); font-weight: 800; border-bottom: 1px solid var(--border); text-align: left; width: 250px;">NPM / Identity</th>
                    <th style="padding: 1.25rem 2rem; background: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: var(--secondary); font-weight: 800; border-bottom: 1px solid var(--border); text-align: left;">Nama Lengkap Nasabah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $index => $s)
                    <tr style="transition: all 0.2s;">
                        <td style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border); color: var(--text-muted); font-weight: 800; font-size: 0.875rem;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; background: var(--primary-light); color: var(--primary-accent); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.65rem;">
                                    ID
                                </div>
                                <span style="font-weight: 800; color: var(--primary); letter-spacing: 0.05em;">{{ $s->npm }}</span>
                            </div>
                        </td>
                        <td style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; color: var(--secondary);">
                                    {{ substr($s->name, 0, 1) }}
                                </div>
                                <span style="font-weight: 700; color: var(--primary);">{{ $s->name }}</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" align="center" style="padding: 6rem 2rem; color: var(--text-muted);">
                            <div style="opacity: 0.3;">
                                <i data-lucide="users-2" style="width: 48px; height: 48px; margin: 0 auto 1.5rem;"></i>
                                <p style="font-weight: 700;">Belum ada data anggota terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
