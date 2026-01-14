<?php
$myBalance = getAccountBalance($pdo, $_SESSION['account_id']);
$totalClassCash = getClassTotalCash($pdo);
$month = date('m');
$year = date('Y');
$monthName = date('F Y');

$view = $_GET['view'] ?? 'compact';
$limit = ($view === 'history') ? 100 : 5;

$stmt = $pdo->prepare("
    SELECT t.*, u.username as creator 
    FROM transactions t 
    JOIN users u ON t.created_by = u.id 
    WHERE t.account_id = ? AND MONTH(t.tanggal) = ? AND YEAR(t.tanggal) = ?
    ORDER BY t.tanggal DESC LIMIT $limit
");
$stmt->execute([$_SESSION['account_id'], $month, $year]);
$recentTransactions = $stmt->fetchAll();
?>

<div class="banking-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 1.5rem;">Sikelas.</h2>
            <p style="font-size: 0.75rem; color: var(--text-muted);">Riwayat Kas - <?php echo $monthName; ?></p>
        </div>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <?php if($view === 'history'): ?>
                <a href="index.php" style="color: var(--primary); text-decoration: none; font-size: 0.875rem; font-weight: 700;">Kembali</a>
            <?php endif; ?>
            <a href="app/actions/logout.php" style="color: var(--danger); text-decoration: none; font-weight: 700; font-size: 0.875rem;">Logout</a>
        </div>
    </div>

    <!-- Personal Card -->
    <div class="bank-card">
        <div class="label">Total Saldo Saya</div>
        <div class="balance"><?php echo formatIDR($myBalance); ?></div>
        <div style="margin-top: 2rem; display: flex; justify-content: space-between; align-items: flex-end;">
            <div style="font-size: 0.875rem; letter-spacing: 1px; font-weight: 600; font-family: monospace;">ID: <?php echo $_SESSION['npm']; ?></div>
            <div style="font-weight: 600; font-size: 0.875rem;"><?php echo $_SESSION['username']; ?></div>
        </div>
    </div>

    <!-- Class Info -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 1rem; margin-bottom: 2rem;">
        <div class="card" style="margin-bottom: 0; display: flex; align-items: center; gap: 1rem; border-left: 4px solid var(--success);">
            <div style="background: #f0fdf4; color: var(--success); padding: 0.75rem; border-radius: 0.75rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <div class="stat-label">Total Dana Kas Kelas</div>
                <div style="font-weight: 700; font-size: 1.125rem; color: var(--text-main);"><?php echo formatIDR($totalClassCash); ?></div>
            </div>
        </div>
    </div>

    <!-- Information Note -->
    <div style="background: #eff6ff; border: 1px solid #dbeafe; border-radius: 1rem; padding: 1rem; margin-bottom: 2rem; display: flex; gap: 0.75rem; align-items: flex-start;">
        <div style="color: var(--primary); margin-top: 0.1rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        </div>
        <p style="font-size: 0.8125rem; color: #1e40af; line-height: 1.4; margin: 0;">
            <strong>Informasi:</strong> Saldo akan diperbarui secara otomatis setelah melalui tahapan <strong>verifikasi dan rekonsiliasi</strong> oleh Bendahara (estimasi 1x24 jam). Untuk rekapitulasi lengkap, silakan hubungi <strong>Bendahara Kelas</strong>.
        </p>
    </div>

    <!-- Transactions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1.125rem;"><?php echo $view === 'history' ? 'Semua Aktivitas' : 'Aktivitas Terupdate'; ?></h3>
        <?php if($view !== 'history'): ?>
            <a href="index.php?view=history" style="font-size: 0.75rem; color: var(--primary); font-weight: 700; text-decoration: none;">Lihat Semua</a>
        <?php endif; ?>
    </div>

    <?php if (empty($recentTransactions)): ?>
        <div class="card" style="text-align: center; padding: 3rem; color: var(--text-muted);">Belum ada pergerakan kas.</div>
    <?php else: ?>
        <?php foreach ($recentTransactions as $tx): ?>
            <div class="card" style="margin-bottom: 0.75rem; padding: 1rem; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: <?php echo $tx['jenis'] === 'setor' ? '#f0fdf4' : '#fef2f2'; ?>; display: flex; align-items: center; justify-content: center; color: <?php echo $tx['jenis'] === 'setor' ? 'var(--success)' : 'var(--danger)'; ?>;">
                        <?php if ($tx['jenis'] === 'setor'): ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        <?php else: ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 0.9375rem;"><?php echo htmlspecialchars($tx['keterangan']); ?></div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo date('d M Y', strtotime($tx['tanggal'])); ?></div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 700; color: <?php echo $tx['jenis'] === 'setor' ? 'var(--success)' : 'var(--danger)'; ?>;">
                        <?php echo ($tx['jenis'] === 'setor' ? '+' : '-') . formatIDR($tx['jumlah']); ?>
                    </div>
                    <div style="font-size: 0.65rem; color: var(--text-muted);">Admin</div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
