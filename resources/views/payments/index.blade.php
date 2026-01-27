@extends('layouts.student')

@section('title', 'Bayar Kas')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('student.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--secondary); text-decoration: none; font-size: 0.8125rem; font-weight: 700;">
        <i data-lucide="chevron-left" style="width: 16px;"></i>
        <span>Kembali ke Dashboard</span>
    </a>
</div>

<div class="glass-card" style="margin-bottom: 1.5rem; text-align: center; background: white; padding: 1.5rem;">
    <div style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--secondary); margin-bottom: 1.25rem;">Scan QRIS Untuk Membayar</div>
    
    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 1.25rem; display: inline-block; margin-bottom: 1.25rem; border: 1px solid var(--border); width: 100%; max-width: 280px;">
        <div id="qris-container" style="width: 200px; height: 200px; background: white; border-radius: 1rem; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; border: 1px solid #e2e8f0; margin: 0 auto;">
            <img src="{{ asset('qris.jpeg') }}" 
                 id="qris-image"
                 style="width: 100%; height: 100%; object-fit: contain; padding: 1rem;"
                 onerror="handleQrError()">
            
            <div id="qris-error" style="display: none; flex-direction: column; align-items: center; justify-content: center; padding: 1rem; text-align: center;">
                <i data-lucide="alert-triangle" style="width: 40px; height: 40px; color: var(--danger); margin-bottom: 0.75rem;"></i>
                <div style="font-size: 0.75rem; font-weight: 800; color: var(--danger); text-transform: uppercase;">QRIS Tidak Tersedia</div>
                <div style="font-size: 0.65rem; color: var(--secondary); margin-top: 0.5rem; font-weight: 600;">Hubungi Bendahara.</div>
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

    <div style="margin-bottom: 1.25rem;">
        <div style="font-weight: 800; font-size: 1rem; color: var(--primary);">Atas Nama: WICAKSONO</div>
        <div style="font-size: 0.65rem; color: var(--secondary); margin-top: 0.5rem; font-weight: 700; background: #fff1f2; color: #e11d48; display: inline-block; padding: 0.375rem 0.875rem; border-radius: 0.625rem; margin-bottom: 1rem; border: 1px solid rgba(225, 29, 72, 0.1);">
            <i data-lucide="shield-check" style="width: 12px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i>
            Pastikan akun DANA atas nama WICAKSONO.
        </div>
    </div>

    <div style="display: flex; justify-center: center; gap: 0.75rem; padding: 0.75rem; background: var(--primary-light); border-radius: 0.875rem; border: 1px dashed var(--primary-accent); margin: 0 auto; max-width: 280px;">
        <i data-lucide="info" style="width: 16px; color: var(--primary-accent); flex-shrink: 0;"></i>
        <div style="text-align: left; font-size: 0.7rem; color: var(--primary-accent); font-weight: 600; line-height: 1.4;">
            Isi form untuk validasi pembayaran.
        </div>
    </div>
</div>

<div class="glass-card" style="background: white; padding: 1.5rem;">
    <h3 style="font-size: 0.9375rem; font-weight: 800; color: var(--primary); margin-bottom: 1.25rem;">Konfirmasi Pembayaran</h3>
    
    <form id="payment-form" action="{{ route('student.pay.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: var(--secondary); margin-bottom: 0.5rem; letter-spacing: 0.05em;">Nominal Transfer</label>
            <div style="position: relative;">
                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); font-weight: 800; color: var(--primary); font-size: 0.9375rem;">Rp</span>
                <input type="number" name="amount" id="amount-input" required placeholder="0" style="padding-left: 3rem; font-size: 1rem; font-weight: 800; height: 50px; border-radius: 0.875rem;" min="1">
            </div>
            @error('amount')
                <p style="color: var(--danger); font-size: 0.7rem; margin-top: 0.4rem; font-weight: 600;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem; display: flex; gap: 0.625rem; align-items: flex-start;">
            <input type="checkbox" id="confirm-check" required style="width: 18px; height: 18px; cursor: pointer; border-radius: 4px; border: 1px solid var(--border);">
            <label for="confirm-check" style="font-size: 0.75rem; color: var(--secondary); font-weight: 600; cursor: pointer; line-height: 1.4;">
                Sudah transfer sesuai nominal.
            </label>
        </div>

        <button type="button" onclick="showConfirmation()" id="submit-trigger" class="btn btn-primary" style="width: 100%; height: 50px; border-radius: 0.875rem; opacity: 0.5; cursor: not-allowed; font-size: 0.875rem;" disabled>
            <i data-lucide="send" style="width: 18px;"></i>
            <span>Konfirmasi & Kirim WA</span>
        </button>

        <div id="proof-attention" style="margin-top: 1.25rem; display: none; background: #fffef0; border: 1px solid #fef3c7; padding: 0.875rem; border-radius: 0.75rem; animation: slideDown 0.3s ease-out;">
            <div style="display: flex; gap: 0.625rem; align-items: flex-start;">
                <i data-lucide="camera" style="width: 16px; color: #b45309; flex-shrink: 0; margin-top: 0.1rem;"></i>
                <p style="font-size: 0.7rem; color: #92400e; font-weight: 700; line-height: 1.4; margin: 0;">
                    Kirim screenshot bukti transfer ke Bendahara setelah ini.
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
        btn.innerText = 'Oke';
        document.getElementById('payment-form').submit();
    }
</script>
@endsection
