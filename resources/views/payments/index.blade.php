@extends('layouts.student')

@section('title', 'Bayar Kas')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('student.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--secondary); text-decoration: none; font-size: 0.875rem; font-weight: 700;">
        <i data-lucide="chevron-left" style="width: 18px;"></i>
        <span>Kembali ke Dashboard</span>
    </a>
</div>

<div class="glass-card" style="margin-bottom: 2rem; text-align: center; background: white;">
    <div style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--secondary); margin-bottom: 1.5rem;">Scan QRIS Untuk Membayar</div>
    
    <div style="background: #f8fafc; padding: 2rem; border-radius: 1.5rem; display: inline-block; margin-bottom: 1.5rem; border: 1px solid var(--border); width: 100%; max-width: 320px;">
        <div id="qris-container" style="width: 240px; height: 240px; background: white; border-radius: 1rem; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; border: 1px solid #e2e8f0; margin: 0 auto;">
            <img src="{{ asset('qris.jpeg') }}" 
                 id="qris-image"
                 style="width: 100%; height: 100%; object-fit: contain; padding: 1rem;"
                 onerror="handleQrError()">
            
            <div id="qris-error" style="display: none; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem; text-align: center;">
                <i data-lucide="alert-triangle" style="width: 48px; height: 48px; color: var(--danger); margin-bottom: 1rem;"></i>
                <div style="font-size: 0.875rem; font-weight: 800; color: var(--danger); text-transform: uppercase;">QRIS Tidak Tersedia</div>
                <div style="font-size: 0.7rem; color: var(--secondary); margin-top: 0.5rem; font-weight: 600;">Harap hubungi Bendahara untuk mendapatkan kode QR yang valid.</div>
            </div>
        </div>
    </div>

    <script>
        function handleQrError() {
            document.getElementById('qris-image').style.display = 'none';
            document.getElementById('qris-error').style.display = 'flex';
            document.getElementById('qris-container').style.border = '2px solid var(--danger)';
            // Disable the form to prevent accidental sumbission if QR is invalid
            document.querySelectorAll('button[type="submit"]').forEach(btn => {
                btn.disabled = true;
                btn.style.opacity = '0.5';
                btn.style.cursor = 'not-allowed';
            });
        }
    </script>

    <div style="margin-bottom: 1.5rem;">
        <div style="font-weight: 800; font-size: 1.125rem; color: var(--primary);">Atas Nama: WICAKSONO</div>
        <div style="font-size: 0.75rem; color: var(--secondary); margin-top: 0.25rem; font-weight: 700; background: #fff1f2; color: #e11d48; display: inline-block; padding: 0.375rem 1rem; border-radius: 0.625rem; margin-bottom: 1rem; border: 1px solid rgba(225, 29, 72, 0.1);">
            <i data-lucide="shield-check" style="width: 14px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i>
            Pastikan akun DANA tujuan atas nama WICAKSONO sebelum memproses transfer.
        </div>
        <div style="font-size: 0.875rem; color: var(--secondary);">Pastikan nominal sesuai saat mentransfer</div>
    </div>

    <div style="display: flex; justify-center: center; gap: 1rem; padding: 0.75rem; background: var(--primary-light); border-radius: 1rem; border: 1px dashed var(--primary-accent); margin: 0 auto; max-width: 320px;">
        <i data-lucide="info" style="width: 18px; color: var(--primary-accent); flex-shrink: 0;"></i>
        <div style="text-align: left; font-size: 0.75rem; color: var(--primary-accent); font-weight: 600; line-height: 1.4;">
            Setelah transfer, isi form di bawah untuk mengirim bukti pembayaran ke Bendahara.
        </div>
    </div>
</div>

<div class="glass-card" style="background: white;">
    <h3 style="font-size: 1rem; font-weight: 800; color: var(--primary); margin-bottom: 1.5rem;">Konfirmasi Pembayaran</h3>
    
    <form id="payment-form" action="{{ route('student.pay.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.75rem;">Nominal Transfer</label>
            <div style="position: relative;">
                <span style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); font-weight: 800; color: var(--primary);">Rp</span>
                <input type="number" name="amount" id="amount-input" required placeholder="0" style="padding-left: 3.5rem; font-size: 1.125rem; font-weight: 800; height: 56px;" min="1">
            </div>
            @error('amount')
                <p style="color: var(--danger); font-size: 0.75rem; margin-top: 0.5rem; font-weight: 600;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 2rem; display: flex; gap: 0.75rem; align-items: flex-start;">
            <input type="checkbox" id="confirm-check" required style="width: 20px; height: 20px; cursor: pointer; border-radius: 6px;">
            <label for="confirm-check" style="font-size: 0.8125rem; color: var(--secondary); font-weight: 600; cursor: pointer; line-height: 1.4;">
                Saya sadar dan menyatakan bahwa saya sudah melakukan transfer ke QRIS di atas sesuai nominal yang saya input.
            </label>
        </div>

        <button type="button" onclick="showConfirmation()" id="submit-trigger" class="btn btn-primary" style="width: 100%; height: 56px; border-radius: 1rem; opacity: 0.5; cursor: not-allowed;" disabled>
            <i data-lucide="send" style="width: 20px;"></i>
            <span>Konfirmasi & Kirim WA</span>
        </button>

        <div id="proof-attention" style="margin-top: 1.5rem; display: none; background: #fffef0; border: 1px solid #fef3c7; padding: 1rem; border-radius: 0.875rem; animation: slideDown 0.3s ease-out;">
            <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                <i data-lucide="camera" style="width: 18px; color: #b45309; flex-shrink: 0; margin-top: 0.1rem;"></i>
                <p style="font-size: 0.75rem; color: #92400e; font-weight: 700; line-height: 1.4; margin: 0;">
                    PERHATIAN: Pastikan Anda mengirimkan bukti transfer (screenshot) ke nomor WhatsApp Bendahara Kelas setelah ini agar transaksi Anda segera divalidasi.
                </p>
            </div>
        </div>

        <style>
            @keyframes slideDown {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </form>
</div>

<!-- Security Confirmation Modal -->
<div id="confirmation-modal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center; padding: 2rem;">
    <div class="glass-card" style="background: white; width: 100%; max-width: 400px; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
        <div style="width: 64px; height: 64px; background: rgba(37, 99, 235, 0.1); color: var(--primary-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
            <i data-lucide="shield-check" style="width: 32px; height: 32px;"></i>
        </div>
        
        <h3 style="font-size: 1.25rem; font-weight: 900; color: var(--primary); text-align: center; margin-bottom: 0.5rem;">Validasi Transaksi</h3>
        <p style="font-size: 0.875rem; color: var(--secondary); text-align: center; margin-bottom: 2rem; line-height: 1.5;">
            Apakah Anda yakin nominal transfer sudah benar? <br>
            <strong id="modal-amount" style="font-size: 1.125rem; color: var(--primary);">Rp 0</strong>
        </p>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <button type="button" onclick="finalSubmit()" id="final-btn" class="btn btn-primary" style="width: 100%; height: 50px; border-radius: 0.875rem;">
                Ya, Kirim Sekarang
            </button>
            <button type="button" onclick="hideConfirmation()" class="btn btn-outline" style="width: 100%; height: 50px; border-radius: 0.875rem; border-color: transparent;">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
    const amountInput = document.getElementById('amount-input');
    const confirmCheck = document.getElementById('confirm-check');
    const submitTrigger = document.getElementById('submit-trigger');
    const proofAttention = document.getElementById('proof-attention');

    // Multi-confirm reactive logic
    function toggleSubmitState() {
        const isChecked = confirmCheck.checked;
        const hasAmount = amountInput.value > 0;
        
        if (isChecked && hasAmount) {
            submitTrigger.disabled = false;
            submitTrigger.style.opacity = '1';
            submitTrigger.style.cursor = 'pointer';
            proofAttention.style.display = 'block';
        } else {
            submitTrigger.disabled = true;
            submitTrigger.style.opacity = '0.5';
            submitTrigger.style.cursor = 'not-allowed';
            proofAttention.style.display = 'none';
        }
    }

    confirmCheck.addEventListener('change', toggleSubmitState);
    amountInput.addEventListener('input', toggleSubmitState);

    function showConfirmation() {
        const amount = amountInput.value;
        const check = confirmCheck.checked;
        
        if (!amount || amount <= 0) {
            alert('Harap masukkan nominal transfer yang valid!');
            return;
        }
        
        if (!check) {
            alert('Harap centang pernyataan konfirmasi terlebih dahulu!');
            return;
        }

        document.getElementById('modal-amount').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        document.getElementById('confirmation-modal').style.display = 'flex';
    }

    function hideConfirmation() {
        document.getElementById('confirmation-modal').style.display = 'none';
    }

    function finalSubmit() {
        const btn = document.getElementById('final-btn');
        btn.disabled = true;
        btn.innerText = 'Memproses...';
        document.getElementById('payment-form').submit();
    }
</script>
@endsection
