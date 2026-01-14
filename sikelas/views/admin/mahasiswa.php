<?php
$stmt = $pdo->query("SELECT u.username, u.npm FROM users u WHERE u.role = 'mahasiswa' ORDER BY u.npm ASC");
$students = $stmt->fetchAll();
?>

<div style="margin-bottom: 2.5rem;">
    <h2 style="font-size: 1.875rem;">Data Mahasiswa</h2>
    <p style="color: var(--text-muted);">Daftar seluruh anggota kelas Sikelas.</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="margin: 0;">Anggota Kelas (<?php echo count($students); ?> Orang)</h3>
        <input type="text" id="member_search" placeholder="Filter Nama atau NPM..." style="width: 250px; padding: 0.5rem; border-radius: 0.5rem; border: 1px solid var(--border); font-size: 0.8125rem;">
    </div>
    
    <table style="width: 100%;" id="member_table">
        <thead>
            <tr>
                <th style="text-align: left; padding: 1rem; border-bottom: 2px solid var(--border);">No</th>
                <th style="text-align: left; padding: 1rem; border-bottom: 2px solid var(--border);">NPM</th>
                <th style="text-align: left; padding: 1rem; border-bottom: 2px solid var(--border);">Nama Lengkap</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $index => $s): ?>
                <tr>
                    <td style="padding: 1rem; border-bottom: 1px solid var(--border); color: var(--text-muted);"><?php echo $index + 1; ?></td>
                    <td style="padding: 1rem; border-bottom: 1px solid var(--border); font-family: monospace;"><?php echo $s['npm']; ?></td>
                    <td style="padding: 1rem; border-bottom: 1px solid var(--border); font-weight: 600;"><?php echo htmlspecialchars($s['username']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('member_search').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#member_table tbody tr');
    
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>
