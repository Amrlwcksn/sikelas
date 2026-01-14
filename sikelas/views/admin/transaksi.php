<?php
$stmt = $pdo->query("
    SELECT u.username, u.npm, a.account_id,
        (SELECT COALESCE(SUM(CASE WHEN jenis = 'setor' THEN jumlah ELSE 0 END), 0) -
                COALESCE(SUM(CASE WHEN jenis = 'keluar' THEN jumlah ELSE 0 END), 0) 
         FROM transactions WHERE account_id = a.account_id) as balance
    FROM users u 
    JOIN accounts a ON u.id = a.user_id 
    WHERE u.role = 'mahasiswa' 
    ORDER BY u.npm ASC
");
$students = $stmt->fetchAll();

$stmt = $pdo->query("
    SELECT t.*, u.username as mhs_name 
    FROM transactions t 
    JOIN accounts a ON t.account_id = a.account_id
    JOIN users u ON a.user_id = u.id
    ORDER BY t.tanggal DESC LIMIT 20
");
$history = $stmt->fetchAll();
?>

<div style="margin-bottom: 2.5rem;">
    <h2 style="font-size: 1.875rem;">Input Transaksi</h2>
    <p style="color: var(--text-muted);">Catat setoran kas atau pengeluaran mahasiswa.</p>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div style="background: #f0fdf4; color: #166534; padding: 1rem; border-radius: 0.75rem; border: 1px solid #bbfcce; margin-bottom: 2rem; font-weight: 600;">
        ✅ <?php echo htmlspecialchars($_GET['msg']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['err'])): ?>
    <div style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 0.75rem; border: 1px solid #fee2e2; margin-bottom: 2rem; font-weight: 600;">
        ❌ <?php echo htmlspecialchars($_GET['err']); ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <div class="card" style="height: fit-content;">
        <h3>Form Transaksi</h3>
        <form action="app/actions/add_transaction.php" method="POST">
            <div class="form-group">
                <label>Pilih Mahasiswa</label>
                <select name="account_id" id="student_select" required onchange="updateBalance()">
                    <option value="" data-balance="0">-- Pilih Mahasiswa --</option>
                    <?php foreach ($students as $s): ?>
                        <option value="<?php echo $s['account_id']; ?>" data-balance="<?php echo $s['balance']; ?>">
                            <?php echo htmlspecialchars($s['username']); ?> (<?php echo $s['npm']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="balance_info" style="margin-top: 0.5rem; font-size: 0.8125rem; font-weight: 700; color: var(--primary); display: none;">
                    Saldo Saat Ini: <span id="current_balance_display">Rp 0</span>
                </div>
            </div>
            <div class="form-group">
                <label>Jenis</label>
                <select name="jenis" required>
                    <option value="setor">Setoran (Masuk)</option>
                    <option value="keluar">Penarikan (Keluar)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nominal (Rp)</label>
                <input type="number" name="jumlah" required min="1" placeholder="50000">
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" rows="3" placeholder="Contoh: Kas Minggu 2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Catat Transaksi</button>
        </form>
    </div>

    <div class="card">
        <h3>Riwayat 20 Terakhir</h3>
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Mahasiswa</th>
                    <th>Keterangan</th>
                    <th style="text-align: right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $tx): ?>
                    <tr>
                        <td style="font-size: 0.75rem; color: var(--text-muted);"><?php echo date('d/m/y H:i', strtotime($tx['tanggal'])); ?></td>
                        <td style="font-weight: 600;"><?php echo htmlspecialchars($tx['mhs_name']); ?></td>
                        <td><?php echo htmlspecialchars($tx['keterangan']); ?></td>
                        <td style="text-align: right; font-weight: 700; color: <?php echo $tx['jenis'] === 'setor' ? 'var(--success)' : 'var(--danger)'; ?>;">
                            <?php echo ($tx['jenis'] === 'setor' ? '+' : '-') . formatIDR($tx['jumlah']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function updateBalance() {
    const select = document.getElementById('student_select');
    const display = document.getElementById('balance_info');
    const span = document.getElementById('current_balance_display');
    
    const selectedOption = select.options[select.selectedIndex];
    const balance = selectedOption.getAttribute('data-balance');
    
    if (select.value) {
        display.style.display = 'block';
        span.innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(balance);
    } else {
        display.style.display = 'none';
    }
}
</script>
