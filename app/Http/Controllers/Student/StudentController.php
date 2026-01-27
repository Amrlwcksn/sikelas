<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $account = $user->account;
        
        $view = $request->get('view', 'compact');
        $limit = ($view === 'history') ? 100 : 5;
        
        $myBalance = 0;
        $recentTransactions = collect();

        if ($account) {
            $myBalance = Transaction::where('account_id', $account->id)
                ->selectRaw('SUM(CASE WHEN jenis = "setor" THEN jumlah ELSE 0 END) - SUM(CASE WHEN jenis = "keluar" THEN jumlah ELSE 0 END) as balance')
                ->value('balance') ?? 0;

            $recentTransactions = Transaction::where('account_id', $account->id)
                ->orderBy('tanggal', 'desc')
                ->limit($limit)
                ->get();
        }

        $totalClassCash = Transaction::where('jenis', 'setor')->sum('jumlah') - 
                          Transaction::where('jenis', 'keluar')->sum('jumlah');

        $totalSetor = Transaction::where('jenis', 'setor')->sum('jumlah');
        $totalKeluar = Transaction::where('jenis', 'keluar')->sum('jumlah');

        // Check if user has paid this week
        $hasPaidThisWeek = false;
        if ($account) {
            $hasPaidThisWeek = Transaction::where('account_id', $account->id)
                ->where('jenis', 'setor')
                ->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])
                ->exists();
        }

        $sarcasticMessages = [
            "Kasihani Bendahara, bayar kas sekarang atau kami kirim penagih hutang ke mimpi Anda!",
            "Uang kas macet, pembangunan surga kelas terhambat. Segera lunasi!",
            "Anda ingin kelas AC tapi bayar kas saja seperti mencicil dosa. Bayar!",
            "Saldo kas menipis setipis kesabaran Bendahara. Yuk bayar!",
            "Jangan biarkan Bendahara menangis di pojokan karena saldo kosong. Bayar kas dong!"
        ];
        $sarcasticMessage = $sarcasticMessages[array_rand($sarcasticMessages)];

        // New Academic Stats
        $activeAssignmentsCount = \App\Models\AcademicTask::where('status', 'active')->count();
        
        $dayMap = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $todayIndo = $dayMap[now()->format('l')] ?? 'Senin';
        $todaySchedulesCount = \App\Models\AcademicCourse::where('day', $todayIndo)->count();

        return view('student.dashboard', compact(
            'myBalance', 
            'totalClassCash', 
            'totalSetor',
            'totalKeluar',
            'hasPaidThisWeek',
            'sarcasticMessage',
            'recentTransactions', 
            'view',
            'activeAssignmentsCount',
            'todaySchedulesCount'
        ));
    }

    public function settings()
    {
        return view('student.settings');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak sesuai SB!']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Sandi sampun digantosipun, mangga dipun jaga keamanan akun panjenengan.');
    }
}
