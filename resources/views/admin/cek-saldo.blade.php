@extends('layouts.admin')

@section('title', 'Cek Saldo Mahasiswa')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Cek Saldo Mahasiswa</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Rincian saldo mahasiswa secara privat dan aman.</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start;">
    <div class="table-container">
        <div style="padding: 2rem; border-bottom: 2px solid var(--bg-main); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <h3 class="text-xl font-bold">Pilih Mahasiswa</h3>
            <div style="position: relative; max-width: 280px; width: 100%;">
                <i data-lucide="search" style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-30%); width: 18px; color: var(--text-muted);"></i>
                <input type="text" id="student_search" placeholder="Cari Nama..." style="padding-left: 3.5rem; margin-top: 0;">
            </div>
        </div>
        
        <div style="max-height: 550px; overflow-y: auto;">
            <table id="student_table">
                <tbody>
                    @foreach ($students as $s)
                        <tr onclick="showStudentDetail('{{ addslashes($s->name) }}', '{{ $s->npm }}', '{{ $balances[$s->account->id ?? 0] ?? 0 }}')" style="cursor: pointer;" class="student-row">
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 40px; height: 40px; background: var(--bg-main); color: var(--text-muted); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.875rem;">
                                        {{ substr($s->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--text-main);">{{ $s->name }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $s->npm }}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div style="position: sticky; top: 2rem;">
        <div id="balance_detail_card" style="display: none;">
            <div class="card" style="background: linear-gradient(135deg, #ffffff 0%, #f1f7ff 100%);">
                <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1rem 0;">
                    <div id="detail_avatar" style="width: 100px; height: 100px; background: var(--primary); color: white; border-radius: 30px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 900; box-shadow: 0 10px 25px -5px rgba(13, 110, 253, 0.4); margin-bottom: 2rem;">
                        A
                    </div>
                    <h3 id="detail_name" class="text-2xl font-black" style="margin-bottom: 0.25rem;">-</h3>
                    <p id="detail_npm" style="color: var(--text-muted); font-weight: 700; margin-bottom: 2.5rem;">NPM: -</p>
                    
                    <div style="width: 100%; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.02); margin-bottom: 2rem;">
                        <span style="font-size: 0.875rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1.5px;">Saldo Terkini</span>
                        <div id="detail_balance" style="font-size: 3rem; font-weight: 900; color: var(--primary); letter-spacing: -2px; margin-top: 0.5rem;">Rp 0</div>
                    </div>

                    <a href="{{ route('admin.transactions') }}" class="btn btn-primary" style="width: 100%;">
                        <i data-lucide="plus-circle"></i> Proses Transaksi Baru
                    </a>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1.5rem; color: var(--text-muted);">
                        <i data-lucide="shield-check" style="width: 16px;"></i>
                        <span style="font-size: 0.75rem; font-weight: 600;">Informasi saldo bersifat privat dan terenkripsi.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="balance_empty_state" style="text-align: center; padding: 6rem 2rem;">
            <div style="width: 80px; height: 80px; background: var(--bg-main); color: var(--text-muted); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; opacity: 0.5;">
                <i data-lucide="user-search" style="width: 32px; height: 32px;"></i>
            </div>
            <h4 class="text-xl font-bold mb-2">Pilih Mahasiswa</h4>
            <p style="color: var(--text-muted); font-weight: 600;">Klik pada daftar di samping untuk melihat rincian saldo.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('student_search').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#student_table tbody tr');
    
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

function showStudentDetail(name, npm, balance) {
    document.getElementById('balance_empty_state').style.display = 'none';
    document.getElementById('balance_detail_card').style.display = 'block';
    
    document.getElementById('detail_name').innerText = name;
    document.getElementById('detail_npm').innerText = 'NPM: ' + npm;
    document.getElementById('detail_avatar').innerText = name.charAt(0).toUpperCase();
    document.getElementById('detail_balance').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(balance);
    
    document.querySelectorAll('.student-row').forEach(r => {
        r.classList.remove('active');
        r.style.background = '';
    });
    const selectedRow = event.currentTarget;
    selectedRow.style.background = 'var(--primary-light)';
    
    // Refresh icons in case any were added dynamically (though not the case here)
    lucide.createIcons();
}
</script>
@endpush

