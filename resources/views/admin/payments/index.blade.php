@extends('layouts.admin')

@section('title', 'Validasi Pembayaran')

@section('content')
<div class="glass-card" style="margin-bottom: 2rem; background: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">Menunggu Validasi</h3>
            <p style="font-size: 0.875rem; color: var(--secondary); margin-top: 0.25rem;">Pastikan data sudah sesuai dengan bukti di WhatsApp</p>
        </div>
        <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); color: var(--primary-accent); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="shield-check"></i>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mahasiswa</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $p)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--primary);">{{ $p->user->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--secondary);">{{ $p->user->npm }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 800; color: var(--success);">Rp {{ number_format($p->amount, 0, ',', '.') }}</div>
                    </td>
                    <td style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500;">
                        {{ \Carbon\Carbon::parse($p->date)->translatedFormat('d M Y') }}
                    </td>
                    <td>
                        <span class="status-badge status-warning">PENDING</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.75rem; justify-content: center;">
                            <form action="{{ route('admin.payments.approve', $p) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.8125rem; border-radius: 0.75rem;" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                    <i data-lucide="check" style="width: 14px;"></i>
                                    Terima
                                </button>
                            </form>
                            <form action="{{ route('admin.payments.reject', $p) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.8125rem; border-radius: 0.75rem; color: var(--danger); border-color: rgba(239, 68, 68, 0.2);" onclick="return confirm('Tolak pembayaran ini?')">
                                    <i data-lucide="x" style="width: 14px;"></i>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 4rem 2rem; opacity: 0.5;">
                        <i data-lucide="smile" style="width: 48px; height: 48px; margin: 0 auto 1.5rem;"></i>
                        <p style="font-weight: 600;">Tidak ada pembayaran yang butuh validasi.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
