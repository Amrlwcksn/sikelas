<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalClassCash = Transaction::where('jenis', 'setor')->sum('jumlah') - 
                          Transaction::where('jenis', 'keluar')->sum('jumlah');
        $totalStudents = User::where('role', 'mahasiswa')->count();
        $totalAccounts = Account::count();

        return view('admin.dashboard', compact('totalClassCash', 'totalStudents', 'totalAccounts'));
    }

    public function students()
    {
        $students = User::where('role', 'mahasiswa')
            ->orderBy('npm')
            ->get();
            
        return view('admin.students', compact('students'));
    }

    public function transactions()
    {
        $students = User::where('role', 'mahasiswa')
            ->with('account')
            ->orderBy('npm')
            ->get();

        $history = Transaction::with(['account.user'])
            ->orderBy('tanggal', 'desc')
            ->limit(20)
            ->get();

        // Calculate current balances for all students
        $balances = DB::table('transactions')
            ->select('account_id', DB::raw('SUM(CASE WHEN jenis = "setor" THEN jumlah ELSE 0 END) - SUM(CASE WHEN jenis = "keluar" THEN jumlah ELSE 0 END) as balance'))
            ->groupBy('account_id')
            ->pluck('balance', 'account_id');

        return view('admin.transactions', compact('students', 'history', 'balances'));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'jenis' => 'required|in:setor,keluar',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Negative balance prevention
        if ($request->jenis === 'keluar') {
            $currentBalance = Transaction::where('account_id', $request->account_id)
                ->selectRaw('SUM(CASE WHEN jenis = "setor" THEN jumlah ELSE 0 END) - SUM(CASE WHEN jenis = "keluar" THEN jumlah ELSE 0 END) as balance')
                ->value('balance') ?? 0;
            
            if ($currentBalance < $request->jumlah) {
                return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk melakukan penarikan!');
            }
        }

        $transaction = Transaction::create([
            'account_id' => $request->account_id,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat!');
    }

    public function rekap(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        $viewType = $request->get('view', 'summary');

        $numDays = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
        
        $students = User::where('role', 'mahasiswa')
            ->with('account')
            ->orderBy('npm')
            ->get();

        $allTransactions = Transaction::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        // Calculate Pivot Data for Matrix/Summary
        $matrix = [];
        $monthlyTotals = []; // [account_id => ['setor' => X, 'keluar' => Y]]

        foreach ($allTransactions as $tx) {
            $accId = $tx->account_id;
            $day = (int)date('j', strtotime($tx->tanggal));
            
            if (!isset($matrix[$accId])) $matrix[$accId] = array_fill(1, $numDays, 0);
            if (!isset($monthlyTotals[$accId])) $monthlyTotals[$accId] = ['setor' => 0, 'keluar' => 0];

            if ($tx->jenis === 'setor') {
                $matrix[$accId][$day] += $tx->jumlah;
                $monthlyTotals[$accId]['setor'] += $tx->jumlah;
            } else {
                $matrix[$accId][$day] -= $tx->jumlah;
                $monthlyTotals[$accId]['keluar'] += $tx->jumlah;
            }
        }

        // Calculate global balances
        $balances = DB::table('transactions')
            ->select('account_id', DB::raw('SUM(CASE WHEN jenis = "setor" THEN jumlah ELSE 0 END) - SUM(CASE WHEN jenis = "keluar" THEN jumlah ELSE 0 END) as balance'))
            ->groupBy('account_id')
            ->pluck('balance', 'account_id');

        return view('admin.rekap', compact(
            'students', 'month', 'year', 'viewType', 'numDays', 'matrix', 'monthlyTotals', 'balances'
        ));
    }

    public function registrasi()
    {
        return view('admin.registrasi');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'npm' => 'required|numeric|digits:8|unique:users,npm',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'npm' => $request->npm,
            'email' => $request->npm . '@student.sikelas.com', // Dummy email for Breeze compatibility
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        Account::create(['user_id' => $user->id]);

        return redirect()->route('admin.students')->with('success', 'Mahasiswa berhasil didaftarkan!');
    }

    public function cekSaldo()
    {
        $students = User::where('role', 'mahasiswa')
            ->with(['account'])
            ->orderBy('npm')
            ->get();

        $balances = DB::table('transactions')
            ->select('account_id', DB::raw('SUM(CASE WHEN jenis = "setor" THEN jumlah ELSE 0 END) - SUM(CASE WHEN jenis = "keluar" THEN jumlah ELSE 0 END) as balance'))
            ->groupBy('account_id')
            ->pluck('balance', 'account_id');

        return view('admin.cek-saldo', compact('students', 'balances'));
    }
}
