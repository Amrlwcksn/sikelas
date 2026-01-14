<?php
$totalClassCash = getClassTotalCash($pdo);
$stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'mahasiswa'");
$studentCount = $stmt->fetch()['count'];

$stmt = $pdo->query("
    SELECT t.*, u.username as mhs_name 
    FROM transactions t 
    JOIN accounts a ON t.account_id = a.account_id
    JOIN users u ON a.user_id = u.id
    ORDER BY t.tanggal DESC LIMIT 5
");
$latestTx = $stmt->fetchAll();
?>

<div style="margin-bottom: 2.5rem;">
    <h2 style="font-size: 1.875rem;">Dashboard Overview</h2>
    <p style="color: var(--text-muted);">Selamat datang kembali, Pengurus. Berikut ringkasan hari ini.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Kas Kelas</div>
        <div class="stat-value" style="color: var(--primary);"><?php echo formatIDR($totalClassCash); ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Jumlah Mahasiswa</div>
        <div class="stat-value"><?php echo $studentCount; ?> <span style="font-size: 1rem; color: var(--text-muted);">Orang</span></div>
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3>Aktivitas Terakhir</h3>
        <a href="index.php?page=rekap" style="font-size: 0.875rem; color: var(--primary); text-decoration: none; font-weight: 600;">Lihat Semua</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Mahasiswa</th>
                <th>Jenis</th>
                <th style="text-align: right;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($latestTx as $tx): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tx['mhs_name']); ?></td>
                    <td>
                        <span style="color: <?php echo $tx['jenis'] === 'setor' ? 'var(--success)' : 'var(--danger)'; ?>; font-weight: 600;">
                            <?php echo ucfirst($tx['jenis']); ?>
                        </span>
                    </td>
                    <td style="text-align: right; font-weight: 700;"><?php echo formatIDR($tx['jumlah']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
