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

        return view('student.dashboard', compact('myBalance', 'totalClassCash', 'recentTransactions', 'view'));
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
