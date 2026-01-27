@extends('layouts.student')

@section('title', 'Transaksi Berhasil')

@section('content')
<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 70vh; text-align: center; padding: 2rem 1rem;">
    <!-- Success Animation / Icon -->
    <div style="position: relative; margin-bottom: 2.5rem;">
        <div style="position: absolute; inset: -20px; background: radial-gradient(circle, rgba(34, 197, 94, 0.2) 0%, transparent 70%); border-radius: 50%; animation: pulse-success 2s infinite;"></div>
        <div style="width: 100px; height: 100px; background: #22c55e; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative; z-index: 10; font-size: 3rem; box-shadow: 0 15px 30px -5px rgba(34, 197, 94, 0.4);">
            <i data-lucide="check-circle-2" style="width: 56px; height: 56px;"></i>
        </div>
    </div>

    <!-- Success Message -->
    <h2 style="font-size: 1.75rem; font-weight: 950; color: var(--primary); margin-bottom: 0.75rem; tracking: -0.05em;">Langkah Terakhir!</h2>
    <p style="font-size: 0.9375rem; color: var(--secondary); font-weight: 600; line-height: 1.6; max-width: 320px; margin-bottom: 3rem;">
        Data transaksi Anda sudah dicatat. Sekarang, klik <strong>OKE</strong> untuk mengirim bukti ke WhatsApp Bendahara.
    </p>

    <!-- Action Buttons -->
    <div style="width: 100%; max-width: 320px; display: flex; flex-direction: column; gap: 1rem;">
        <a href="{{ session('wa_link') }}" target="_blank" class="btn btn-primary" style="width: 100%; height: 60px; border-radius: 1.25rem; font-size: 1.125rem; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
            <span>OKE</span>
            <i data-lucide="external-link" style="width: 20px;"></i>
        </a>
        
        <a href="{{ route('student.dashboard') }}?success=1" class="btn btn-outline" style="width: 100%; height: 56px; border-radius: 1.25rem; font-size: 0.9375rem; font-weight: 700; border-color: var(--border);">
            Kembali ke Beranda
        </a>
    </div>

    <!-- Warning/Reminder Footnote -->
    <div style="margin-top: 3rem; padding: 1.25rem; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 1rem; display: flex; gap: 0.75rem; text-align: left; align-items: flex-start;">
        <i data-lucide="info" style="width: 18px; color: #b45309; flex-shrink: 0; margin-top: 0.125rem;"></i>
        <p style="font-size: 0.75rem; color: #92400e; font-weight: 650; line-height: 1.5; margin: 0;">
            Transaksi belum dianggap sah jika Anda belum mengirim bukti transfer dan disetujui oleh Bendahara.
        </p>
    </div>
</div>

<style>
@keyframes pulse-success {
    0% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.4); opacity: 0; }
    100% { transform: scale(1); opacity: 0.5; }
}
</style>

<script>
    // Redirect to WA automatically after 3 seconds if user hasn't clicked? 
    // Maybe better to let them click OKE for better UX as requested.
</script>
@endsection
