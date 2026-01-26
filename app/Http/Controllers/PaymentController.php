<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payments.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $payment = $user->payments()->create([
            'amount' => $request->amount,
            'date' => now()->toDateString(),
            'status' => 'pending',
            'proof' => 'via_wa',
        ]);

        $no_wa_admin = "6285156768860"; // Updated per request
        $nama_user = $user->name;
        $jumlah = number_format($request->amount, 0, ',', '.');
        $tanggal = now()->toDateString();

        $pesan = "Notifikasi Pembayaran Kas Kelas\n";
        $pesan .= "================================\n";
        $pesan .= "Nama: *$nama_user*\n";
        $pesan .= "Nominal: *Rp $jumlah*\n";
        $pesan .= "Tanggal: $tanggal\n";
        $pesan .= "================================\n";
        $pesan .= "Bukti transfer terlampir (silakan kirim foto).";

        $link_wa = "https://api.whatsapp.com/send?phone=$no_wa_admin&text=" . rawurlencode($pesan);

        return redirect()->away($link_wa);
    }

    public function validasi()
    {
        $payments = Payment::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function approve(Payment $payment)
    {
        $payment->update(['status' => 'approved']);

        // Use relationship to find account
        $user = $payment->user;
        $account = $user->account;
        
        if (!$account) {
            // Auto create account if missing (failsafe)
            $account = $user->account()->create();
        }

        \App\Models\Transaction::create([
            'account_id' => $account->id,
            'jenis' => 'setor',
            'jumlah' => $payment->amount,
            'tanggal' => now(),
            'keterangan' => 'Pembayaran QRIS - ' . $user->npm,
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Pembayaran oleh ' . $user->name . ' berhasil dikonfirmasi');
    }

    public function reject(Payment $payment)
    {
        $payment->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Pembayaran ditolak');
    }
}
