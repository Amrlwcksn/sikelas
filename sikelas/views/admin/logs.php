<?php
if (!isPengurus()) {
    header("Location: index.php?error=Unauthorized");
    exit;
}

$stmt = $pdo->query("
    SELECT l.*, u.username as actor_name 
    FROM logs l 
    LEFT JOIN users u ON l.user_id = u.id 
    ORDER BY l.created_at DESC 
    LIMIT 100
");
$logs = $stmt->fetchAll();
?>

<div style="margin-bottom: 2.5rem;">
    <h2 style="font-size: 1.875rem;">Log Aktivitas</h2>
    <p style="color: var(--text-muted);">Audit trail untuk memantau semua aksi penting di sistem.</p>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="excel-table">
        <thead>
            <tr>
                <th width="180">Waktu</th>
                <th width="150">Pelaku</th>
                <th width="120">Aksi</th>
                <th>Detail Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): 
                $badgeColor = '#94a3b8'; // default
                if ($log['action'] === 'LOGIN') $badgeColor = '#3b82f6';
                if ($log['action'] === 'ADD_TX') $badgeColor = '#10b981';
                if ($log['action'] === 'ADD_USER') $badgeColor = '#f59e0b';
                if ($log['action'] === 'LOGOUT') $badgeColor = '#ef4444';
            ?>
                <tr>
                    <td style="font-size: 0.8rem; color: var(--text-muted);">
                        <?php echo date('d M Y, H:i:s', strtotime($log['created_at'])); ?>
                    </td>
                    <td style="font-weight: 700;">
                        <?php echo htmlspecialchars($log['actor_name'] ?? 'System'); ?>
                    </td>
                    <td>
                        <span style="display: inline-block; padding: 0.2rem 0.5rem; border-radius: 0.25rem; background: <?php echo $badgeColor; ?>; color: white; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">
                            <?php echo $log['action']; ?>
                        </span>
                    </td>
                    <td style="font-size: 0.85rem;">
                        <?php echo htmlspecialchars($log['detail']); ?>
                        <?php if($log['target_type']): ?>
                            <span style="color: var(--text-muted); font-size: 0.75rem;">
                                (<?php echo $log['target_type']; ?>: <?php echo $log['target_id']; ?>)
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem; color: var(--text-muted); font-size: 0.75rem; font-style: italic;">
    * Menampilkan 100 aktivitas terbaru untuk menjaga performa.
</div>
