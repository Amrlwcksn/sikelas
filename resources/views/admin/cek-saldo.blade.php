@extends('layouts.admin')

@section('title', 'Cek Saldo Mahasiswa')

@push('styles')
    <style>
        @media print {
            body { background: white !important; color: black !important; -webkit-print-color-adjust: exact; }
            .no-print, .sidebar, header, nav, .view-toggle, .glass-card, .btn, .mb-8 { display: none !important; }
            .main-content { margin: 0 !important; padding: 0 !important; width: 100% !important; background: white !important; }
            
            #print_letter { display: block !important; }
            @page { size: portrait; margin: 2cm; }
        }
    </style>
@endpush

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black">Layanan Cek Saldo</h2>
    <p style="color: var(--text-muted); font-size: 1.125rem;">Informasi rincian tabungan mahasiswa secara privat & terenkripsi.</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start;">
    <!-- Search & List -->
    <div class="glass-card" style="background: white; padding: 0; overflow: hidden;">
        <div style="padding: 2rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <h3 class="text-xl font-bold">Daftar Nasabah</h3>
            <div style="position: relative; max-width: 280px; width: 100%;">
                <i data-lucide="search" style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); width: 16px; color: var(--text-muted);"></i>
                <input type="text" id="student_search" placeholder="Cari Nama / NPM..." style="padding-left: 3.25rem; background: var(--bg-main); border-radius: 2rem;">
            </div>
        </div>
        
        <div style="max-height: 550px; overflow-y: auto;">
            <table id="student_table" style="width: 100%; border-collapse: collapse;">
                <tbody>
                    @foreach ($students as $s)
                        <tr onclick="showStudentDetail('{{ addslashes($s->name) }}', '{{ $s->npm }}', '{{ $balances[$s->account->id ?? 0] ?? 0 }}')" style="cursor: pointer; transition: all 0.2s;" class="student-row">
                            <td style="padding: 1.25rem 2rem; border-bottom: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 44px; height: 44px; background: var(--bg-main); color: var(--secondary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem;">
                                        {{ substr($s->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 800; color: var(--primary);">{{ $s->name }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">{{ $s->npm }}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail View -->
    <div style="position: sticky; top: 2rem;">
        <div id="balance_detail_card" style="display: none;">
            <div class="glass-card" style="background: white; padding: 2.5rem; text-align: center; border-radius: 2rem;">
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <div id="detail_avatar" style="width: 110px; height: 110px; background: var(--grad-banking); color: white; border-radius: 2rem; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 950; box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.4); margin-bottom: 2rem;">
                        A
                    </div>
                    <h3 id="detail_name" class="text-2xl font-black" style="margin-bottom: 0.5rem; color: var(--primary);">N/A</h3>
                    <p id="detail_npm" style="color: var(--secondary); font-weight: 700; font-size: 0.875rem; background: var(--primary-light); padding: 0.25rem 1rem; border-radius: 2rem; margin-bottom: 2.5rem;">NPM: 00000000</p>
                    
                    <div style="width: 100%; background: #f8fafc; padding: 2.5rem; border-radius: 2rem; border: 1px solid var(--border); margin-bottom: 2rem;">
                        <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">Estimated Balance</span>
                        <div id="detail_balance" style="font-size: 2.75rem; font-weight: 950; color: var(--primary); letter-spacing: -1.5px; margin-top: 0.5rem;">Rp 0</div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; width: 100%;">
                        <a href="{{ route('admin.transactions') }}" class="btn btn-primary" style="padding: 1.125rem; border-radius: 1.25rem;">
                            <i data-lucide="plus-circle"></i> Deposit
                        </a>
                        <button class="btn btn-outline" style="padding: 1.125rem; border-radius: 1.25rem;" onclick="window.print()">
                            <i data-lucide="printer"></i> Cetak
                        </button>
                    </div>
                    
                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 2rem; color: var(--text-muted); opacity: 0.6;">
                        <i data-lucide="shield-check" style="width: 14px;"></i>
                        <span style="font-size: 0.625rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Certified Financial Report</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card" id="balance_empty_state" style="background: white; text-align: center; padding: 6rem 3rem; border-radius: 2rem;">
            <div style="width: 80px; height: 80px; background: var(--bg-main); color: var(--primary-light); border-radius: 24px; display: flex; align-items: center; justify-content: center; margin: 0 auto 2.5rem;">
                <i data-lucide="user-search" style="width: 36px; height: 36px; color: var(--secondary);"></i>
            </div>
            <h4 class="text-xl font-bold mb-3">Pilih Akun Nasabah</h4>
            <p style="color: var(--text-muted); font-weight: 500; font-size: 0.9375rem; line-height: 1.6;">Klik pada daftar mahasisa di samping untuk mengakses rincian saldo digital mereka.</p>
        </div>
    </div>
</div>

<!-- Hidden Print Letter Template -->
<!-- Hidden Print Letter Template (Certificate Check Style) -->
<!-- Hidden Print Letter Template (Certificate Check Style) -->
<!-- Hidden Print Letter Template (Certificate Check Style) -->
<div id="print_letter" style="display: none; padding: 2rem; font-family: 'Times New Roman', serif; color: black; width: 100%; margin: 0 auto; box-sizing: border-box;">
    
    <div style="border: 2px solid #333; position: relative; padding: 2.5rem; background-image: radial-gradient(#ddd 1px, transparent 1px); background-size: 10px 10px; min-height: 500px;">
        
        <!-- Document Code (Corner) -->
        <div style="position: absolute; top: 0; right: 0; background: white; border-bottom: 1px solid black; border-left: 1px solid black; padding: 4px 8px; z-index: 20;">
            <p style="font-size: 8pt; font-weight: bold; font-family: sans-serif; margin: 0;">DOK.ID: FIN-02.VLD.SALDO</p>
            <p style="font-size: 7pt; font-family: sans-serif; text-align: right; margin: 0;">VALIDASI CEK SALDO INDIVIDU</p>
        </div>

        <!-- Check Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; margin-bottom: 3.5rem; gap: 2rem;">
            <div style="flex: 1; min-width: 300px;">
                <h1 style="font-size: 18pt; font-weight: 900; margin: 0; line-height: 1.2; text-transform: uppercase;">Genite24 Treasury</h1>
                <p style="font-size: 11pt; margin: 0.25rem 0 0 0;">Sikelas Platform &bull; Semarang</p>
            </div>
            
            <div style="display: flex; gap: 2.5rem; align-items: flex-start; flex-wrap: wrap;">
                <!-- Signature Stamp -->
                <div style="text-align: center; width: 160px;">
                     <div style="border-bottom: 2px solid black; height: 35px; margin-bottom: 6px;"></div>
                     <p style="font-size: 8pt; font-weight: bold; text-transform: uppercase; margin: 0;">Bendahara / Treasurer</p>
                </div>

                <div style="text-align: right;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; justify-content: flex-end;">
                        <span style="font-size: 10pt; font-weight: bold; white-space: nowrap;">DATE</span>
                        <div style="border-bottom: 2px solid black; width: 140px; text-align: center; font-family: 'Courier New', monospace; font-weight: bold; font-size: 12pt;">{{ date('d/m/Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statement Row 1 (Name) -->
        <div style="margin-bottom: 2.5rem; display: flex; align-items: flex-end; gap: 1.5rem; flex-wrap: wrap;">
            <div style="font-size: 12pt; font-weight: bold; padding-bottom: 5px; text-transform: uppercase; white-space: nowrap;">Menerangkan Bahwa / Certifies That</div>
            <div id="print_name" style="flex-grow: 1; border-bottom: 2px solid black; font-family: 'Courier New', monospace; font-size: 16pt; font-weight: bold; padding-bottom: 5px; padding-left: 1rem; text-transform: uppercase; min-width: 200px; line-height: 1.2;">Student Name</div>
        </div>

        <!-- Statement Row 2 (Balance) -->
        <div style="margin-bottom: 3rem; display: flex; align-items: flex-end; justify-content: space-between; gap: 2rem; flex-wrap: wrap;">
            <div style="font-size: 12pt; font-weight: bold; padding-bottom: 5px; flex: 2; min-width: 350px; line-height: 1.5;">
                Memiliki total tabungan kas aktif dalam Sistem Sikelas sebesar:<br>
                <span style="font-size: 10pt; font-weight: normal; font-style: italic;">Has a total active cash savings balance in Sikelas System of:</span>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; flex: 1; justify-content: flex-end; min-width: 300px;">
                <span style="font-size: 18pt; font-weight: bold;">Rp</span>
                <div id="print_balance" style="border: 3px solid black; padding: 0.75rem 1.5rem; min-width: 220px; font-family: 'Courier New', monospace; font-weight: 900; font-size: 20pt; background: white; text-align: right; box-shadow: 4px 4px 0 rgba(0,0,0,0.1);">0</div>
            </div>
        </div>

        <!-- Memo Row (NPM) -->
        <div style="margin-bottom: 5rem; display: flex; align-items: flex-end; gap: 1.5rem; flex-wrap: wrap;">
             <div style="font-size: 11pt; font-weight: bold; white-space: nowrap; padding-bottom: 5px;">ID ACCOUNT (NPM)</div>
             <div style="flex-grow: 1; border-bottom: 2px solid black; font-family: 'Courier New', monospace; font-size: 14pt; padding-bottom: 5px; padding-left: 1rem; min-width: 200px;">
                <span id="print_npm">00000000</span> <span style="font-style: italic; margin-left: 1.5rem; font-size: 11pt;">(Verified & Valid)</span>
             </div>
        </div>

        <!-- Bottom Security Strip (MICR) -->
        <div style="position: absolute; bottom: 20px; left: 2.5rem; right: 2.5rem; padding-top: 1.5rem; border-top: 1px dashed #999;">
             <!-- Simulated MICR Line -->
             <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
                 
                 <div style="font-size: 8pt; color: #555; font-style: italic; background: white; padding: 2px 5px;">
                    Official financial document. Valid without wet stamp. Generated by Sikelas System.
                 </div>
             </div>
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
    // Show Screen Card
    document.getElementById('balance_empty_state').style.display = 'none';
    document.getElementById('balance_detail_card').style.display = 'block';
    
    document.getElementById('detail_name').innerText = name;
    document.getElementById('detail_avatar').innerText = name.charAt(0);
    document.getElementById('detail_npm').innerText = 'NPM: ' + npm;
    
    const formattedBalance = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(balance);
    document.getElementById('detail_balance').innerText = formattedBalance;

    // Populate Print Letter
    document.getElementById('print_name').innerText = name;
    document.getElementById('print_npm').innerText = npm;
    document.getElementById('print_balance').innerText = formattedBalance;
}
</script>

@endpush
