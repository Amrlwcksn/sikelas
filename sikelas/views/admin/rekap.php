<?php
$currentMonth = $_GET['month'] ?? date('m');
$currentYear = $_GET['year'] ?? date('Y');
$monthName = date('F Y', strtotime("$currentYear-$currentMonth-01"));
$numDays = cal_days_in_month(CAL_GREGORIAN, (int)$currentMonth, (int)$currentYear);

// 1. Fetch Students
$stmt = $pdo->query("
    SELECT u.username, u.npm, a.account_id
    FROM users u
    JOIN accounts a ON u.id = a.user_id
    WHERE u.role = 'mahasiswa'
    ORDER BY u.npm ASC
");
$students = $stmt->fetchAll();

// 2. Fetch Transactions for the current month
$stmt = $pdo->prepare("
    SELECT account_id, DAY(tanggal) as tgl, jenis, jumlah
    FROM transactions
    WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
");
$stmt->execute([$currentMonth, $currentYear]);
$allTransactions = $stmt->fetchAll();

// 3. Fetch Total Balance (Global, not just this month)
$stmt = $pdo->query("
    SELECT account_id,
        SUM(CASE WHEN jenis = 'setor' THEN jumlah ELSE 0 END) -
        SUM(CASE WHEN jenis = 'keluar' THEN jumlah ELSE 0 END) as balance
    FROM transactions
    GROUP BY account_id
");
$balances = [];
foreach ($stmt->fetchAll() as $b) {
    $balances[$b['account_id']] = $b['balance'];
}

// 4. Pivot Data in PHP
$matrix = [];
$monthlyTotals = []; // [account_id => ['setor' => X, 'keluar' => Y]]

foreach ($allTransactions as $tx) {
    $accId = $tx['account_id'];
    $day = $tx['tgl'];
    
    if (!isset($matrix[$accId])) $matrix[$accId] = array_fill(1, $numDays, 0);
    if (!isset($monthlyTotals[$accId])) $monthlyTotals[$accId] = ['setor' => 0, 'keluar' => 0];

    if ($tx['jenis'] === 'setor') {
        $matrix[$accId][$day] += $tx['jumlah'];
        $monthlyTotals[$accId]['setor'] += $tx['jumlah'];
    } else {
        $matrix[$accId][$day] -= $tx['jumlah'];
        $monthlyTotals[$accId]['keluar'] += $tx['jumlah'];
    }
}

$viewType = $_GET['view'] ?? 'summary';
?>

<div class="print-header" style="display: none; text-align: center; margin-bottom: 2rem; border-bottom: 2px solid #000; padding-bottom: 1rem;">
    <h1 style="margin: 0; font-size: 1.5rem; text-transform: uppercase;">Laporan Bulanan Kas Kelas - Sikelas.</h1>
    <p style="margin: 0.25rem 0; font-size: 1rem;">Periode: <strong><?php echo $monthName; ?></strong></p>
    <p style="margin: 0; font-size: 0.75rem; color: #666;">Dicetak pada: <?php echo date('d/m/Y H:i'); ?></p>
</div>

<div style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;" class="no-print">
    <div>
        <h2 style="font-size: 1.875rem;">Laporan Kas Kas</h2>
        <p style="color: var(--text-muted);">Periode laporan <strong><?php echo $monthName; ?></strong>.</p>
    </div>
    
    <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
        <!-- Month/Year Filter Form -->
        <form method="GET" action="index.php" style="display: flex; gap: 0.5rem; background: #fff; padding: 0.5rem; border-radius: 0.75rem; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
            <input type="hidden" name="page" value="rekap">
            <input type="hidden" name="view" value="<?php echo $viewType; ?>">
            
            <select name="month" onchange="this.form.submit()" style="padding: 0.4rem; border: none; font-weight: 600; cursor: pointer; background: transparent; outline: none;">
                <?php for($m=1; $m<=12; $m++): $mVal = sprintf('%02d', $m); ?>
                    <option value="<?php echo $mVal; ?>" <?php echo $currentMonth == $mVal ? 'selected' : ''; ?>>
                        <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                    </option>
                <?php endfor; ?>
            </select>
            
            <select name="year" onchange="this.form.submit()" style="padding: 0.4rem; border: none; font-weight: 600; cursor: pointer; background: transparent; outline: none;">
                <?php for($y=date('Y'); $y>=date('Y')-2; $y--): ?>
                    <option value="<?php echo $y; ?>" <?php echo $currentYear == $y ? 'selected' : ''; ?>><?php echo $y; ?></option>
                <?php endfor; ?>
            </select>
        </form>

        <div style="display: flex; gap: 0.5rem; background: #f1f5f9; padding: 0.25rem; border-radius: 0.75rem;">
            <a href="index.php?page=rekap&view=summary&month=<?php echo $currentMonth; ?>&year=<?php echo $currentYear; ?>" class="view-btn <?php echo $viewType === 'summary' ? 'active' : ''; ?>">Ringkasan</a>
            <a href="index.php?page=rekap&view=matrix&month=<?php echo $currentMonth; ?>&year=<?php echo $currentYear; ?>" class="view-btn <?php echo $viewType === 'matrix' ? 'active' : ''; ?>">Matriks Harian</a>
        </div>
    </div>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 1.125rem;"><?php echo $viewType === 'summary' ? 'Ringkasan Bulanan' : 'Detail Arus Kas Harian'; ?></h3>
        <button onclick="window.print()" class="btn" style="width: auto; padding: 0.5rem 1rem; font-size: 0.75rem; background: var(--text-main); color: white;">Cetak Laporan</button>
    </div>

    <div style="overflow-x: auto;">
        <table class="excel-table">
            <thead>
                <?php if ($viewType === 'summary'): ?>
                    <tr>
                        <th width="50">No</th>
                        <th>Mahasiswa</th>
                        <th style="text-align: right;">Pemasukan (Bulan Ini)</th>
                        <th style="text-align: right;">Pengeluaran (Bulan Ini)</th>
                        <th style="text-align: right; background: #eff6ff;">Total Saldo</th>
                    </tr>
                <?php else: ?>
                    <tr>
                        <th rowspan="2" width="40">No</th>
                        <th rowspan="2" style="min-width: 150px;">Nama</th>
                        <th colspan="<?php echo $numDays; ?>" style="text-align: center; border-bottom: 1px solid var(--border);">Tanggal (Arus Kas)</th>
                        <th rowspan="2" align="right" style="min-width: 100px;">Total</th>
                    </tr>
                    <tr style="font-size: 0.65rem;">
                        <?php for ($d = 1; $d <= $numDays; $d++): 
                            $isDivider = ($d % 7 == 0 && $d < $numDays);
                            $dividerStyle = $isDivider ? 'border-right: 2px solid var(--primary);' : '';
                        ?>
                            <th width="30" style="text-align: center; <?php echo $dividerStyle; ?>"><?php echo $d; ?></th>
                        <?php endfor; ?>
                    </tr>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($students as $s): 
                    $accId = $s['account_id'];
                    $setor = $monthlyTotals[$accId]['setor'] ?? 0;
                    $keluar = $monthlyTotals[$accId]['keluar'] ?? 0;
                    $totalSaldo = $balances[$accId] ?? 0;
                ?>
                    <tr>
                        <td align="center" style="color: var(--text-muted);"><?php echo $no++; ?></td>
                        <td>
                            <div style="font-weight: 700;"><?php echo htmlspecialchars($s['username']); ?></div>
                            <?php if($viewType === 'summary'): ?>
                                <div style="font-size: 0.7rem; color: var(--text-muted);"><?php echo $s['npm']; ?></div>
                            <?php endif; ?>
                        </td>
                        <?php if ($viewType === 'summary'): ?>
                            <td align="right" style="color: var(--success); font-weight: 600;"><?php echo formatIDR($setor); ?></td>
                            <td align="right" style="color: var(--danger);"><?php echo formatIDR($keluar); ?></td>
                            <td align="right" style="font-weight: 800; color: var(--primary); background: #f0f7ff;"><?php echo formatIDR($totalSaldo); ?></td>
                        <?php else: ?>
                            <?php for ($d = 1; $d <= $numDays; $d++): 
                                $dayVal = $matrix[$accId][$d] ?? 0;
                                $isDivider = ($d % 7 == 0 && $d < $numDays);
                                $dividerStyle = $isDivider ? 'border-right: 2px solid var(--primary);' : '';
                            ?>
                                <td align="center" class="<?php 
                                    if ($dayVal > 0) echo 'cell-has-data'; 
                                    elseif ($dayVal < 0) echo 'cell-has-out'; 
                                    else echo 'cell-empty'; 
                                ?>" style="font-size: 0.7rem; padding: 0.5rem 0.25rem; <?php echo $dividerStyle; ?>">
                                    <?php 
                                        if ($dayVal > 0) echo number_format($dayVal, 0, ',', '.');
                                        elseif ($dayVal < 0) echo '(' . number_format(abs($dayVal), 0, ',', '.') . ')';
                                        else echo '-';
                                    ?>
                                </td>
                            <?php endfor; ?>
                            <td align="right" style="font-weight: 700; background: #f8fafc; color: <?php echo ($setor - $keluar) >= 0 ? 'var(--primary)' : 'var(--danger)'; ?>;">
                                <?php echo formatIDR($setor - $keluar); ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot style="background: #f8fafc; font-weight: 800;">
                <tr>
                    <td colspan="2" align="right" style="text-transform: uppercase; font-size: 0.7rem;">Total Kolektif</td>
                    <?php if ($viewType === 'summary'): ?>
                        <td align="right" style="color: var(--success);"><?php echo formatIDR(array_sum(array_column($monthlyTotals, 'setor'))); ?></td>
                        <td align="right" style="color: var(--danger);"><?php echo formatIDR(array_sum(array_column($monthlyTotals, 'keluar'))); ?></td>
                        <td align="right" style="background: var(--primary); color: white;"><?php echo formatIDR(array_sum($balances)); ?></td>
                    <?php else: ?>
                        <?php 
                        $totalByDay = array_fill(1, $numDays, 0);
                        foreach ($matrix as $userDays) {
                            foreach ($userDays as $d => $val) {
                                $totalByDay[$d] += $val;
                            }
                        }
                        for ($d = 1; $d <= $numDays; $d++): 
                            $isDivider = ($d % 7 == 0 && $d < $numDays);
                            $dividerStyle = $isDivider ? 'border-right: 2px solid var(--primary);' : '';
                        ?>
                            <td align="center" style="font-size: 0.6rem; <?php echo $dividerStyle; ?> color: <?php echo $totalByDay[$d] >= 0 ? 'inherit' : 'var(--danger)'; ?>;">
                                <?php 
                                    if ($totalByDay[$d] > 0) echo number_format($totalByDay[$d], 0, ',', '.');
                                    elseif ($totalByDay[$d] < 0) echo '(' . number_format(abs($totalByDay[$d]), 0, ',', '.') . ')';
                                    else echo '-';
                                ?>
                            </td>
                        <?php endfor; ?>
                        <td align="right" style="background: var(--primary); color: white;"><?php echo formatIDR(array_sum(array_column($monthlyTotals, 'setor')) - array_sum(array_column($monthlyTotals, 'keluar'))); ?></td>
                    <?php endif; ?>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="print-footer" style="display: none; margin-top: 3rem; justify-content: space-between;">
    <div style="text-align: center; width: 200px;">
        <p style="margin-bottom: 4rem;">Mengetahui,<br><strong>Ketua Kelas</strong></p>
        <div style="border-top: 1px solid #000; padding-top: 0.5rem;">( ................................. )</div>
    </div>
    <div style="text-align: center; width: 200px;">
        <p style="margin-bottom: 4rem;">Dicatat oleh,<br><strong>Bendahara</strong></p>
        <div style="border-top: 1px solid #000; padding-top: 0.5rem;">( ................................. )</div>
    </div>
</div>

<style>
.view-btn {
    padding: 0.5rem 1rem;
    text-decoration: none;
    color: var(--text-muted);
    font-size: 0.8125rem;
    font-weight: 600;
    border-radius: 0.5rem;
    transition: all 0.2s;
}
.view-btn.active {
    background: white;
    color: var(--primary);
    box-shadow: var(--shadow);
}

.excel-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8125rem;
}
.excel-table th {
    border: 1px solid var(--border);
    background: #f1f5f9;
    padding: 0.75rem 0.5rem;
}
.excel-table td {
    border: 1px solid var(--border);
    padding: 0.75rem 1rem;
}
.cell-has-data { background: #f0fdf4; color: var(--success); font-weight: 700; border-color: #dcfce7 !important; }
.cell-has-out { background: #fef2f2; color: var(--danger); font-weight: 700; border-color: #fee2e2 !important; }
.cell-empty { color: #cbd5e1; }

@media print {
    .no-print, .view-btn, .sidebar, header, .btn { display: none !important; }
    .print-header { display: block !important; }
    .print-footer { display: flex !important; }
    .main-content { margin: 0 !important; padding: 0 !important; width: 100% !important; }
    body { background: white !important; }
    .card { border: none !important; box-shadow: none !important; padding: 0 !important; }
    
    .excel-table { font-size: 0.55rem; width: 100% !important; border: 1px solid #000 !important; }
    .excel-table th, .excel-table td { 
        padding: 0.2rem !important; 
        border: 1px solid #000 !important; 
        color: black !important;
    }
    .excel-table th { background: #f0f0f0 !important; -webkit-print-color-adjust: exact; }
    .cell-has-data { background: #e8f5e9 !important; -webkit-print-color-adjust: exact; }
    
    @page {
        size: landscape;
        margin: 1cm;
    }
}
</style>
