<?php
$stmt = $pdo->query("
    SELECT u.username, u.npm, u.id, a.account_id,
        (SELECT COALESCE(SUM(CASE WHEN jenis = 'setor' THEN jumlah ELSE 0 END), 0) -
                COALESCE(SUM(CASE WHEN jenis = 'keluar' THEN jumlah ELSE 0 END), 0) 
         FROM transactions WHERE account_id = a.account_id) as current_balance
    FROM users u
    JOIN accounts a ON u.id = a.user_id
    WHERE u.role = 'mahasiswa'
    ORDER BY u.npm ASC
");
$students = $stmt->fetchAll();
?>

<div style="margin-bottom: 2.5rem;">
    <h2 style="font-size: 1.875rem;">Cek Saldo Mahasiswa</h2>
    <p style="color: var(--text-muted);">Cek detail saldo mahasiswa secara privat dan aman.</p>
</div>

<div style="display: grid; grid-template-columns: 2fr 1.2fr; gap: 2rem;">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0;">Pilih Mahasiswa</h3>
            <div style="position: relative;">
                <input type="text" id="student_search" placeholder="Cari Nama atau NPM..." style="width: 280px; padding: 0.6rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); font-size: 0.8125rem; outline: none; transition: border-color 0.2s;">
            </div>
        </div>
        
        <div style="max-height: 500px; overflow-y: auto;">
            <table style="width: 100%; border-collapse: collapse;" id="student_table">
                <thead>
                    <tr style="position: sticky; top: 0; background: white; z-index: 1;">
                        <th style="text-align: left; padding: 1rem; border-bottom: 2px solid var(--border);">Nama Mahasiswa</th>
                        <th style="text-align: left; padding: 1rem; border-bottom: 2px solid var(--border);">NPM</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $s): ?>
                        <tr onclick="showStudentDetail('<?php echo htmlspecialchars($s['username']); ?>', '<?php echo $s['npm']; ?>', '<?php echo $s['current_balance']; ?>')" style="cursor: pointer;" class="student-row">
                            <td style="padding: 1rem; border-bottom: 1px solid var(--border); font-weight: 600;"><?php echo htmlspecialchars($s['username']); ?></td>
                            <td style="padding: 1rem; border-bottom: 1px solid var(--border); color: var(--text-muted);"><?php echo $s['npm']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" id="balance_detail_card" style="display: none; height: fit-content; position: sticky; top: 2rem; border-top: 4px solid var(--primary);">
        <h3 style="display: flex; align-items: center; gap: 0.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Informasi Saldo
        </h3>
        <div style="margin-top: 1.5rem; text-align: center; padding: 2rem; background: #f8fafc; border-radius: 1rem; border: 1px dashed #cbd5e1;">
            <div id="detail_avatar" style="width: 72px; height: 72px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; font-weight: 800; margin: 0 auto 1.25rem;">
                -
            </div>
            <h4 id="detail_name" style="margin: 0; font-size: 1.25rem; font-weight: 700;">-</h4>
            <p id="detail_npm" style="font-size: 0.8125rem; color: var(--text-muted); margin: 0.25rem 0 1.5rem;">NPM: -</p>
            
            <div style="background: white; padding: 1.25rem; border-radius: 1rem; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; font-weight: 600;">Saldo Tersedia</div>
                <div id="detail_balance" style="font-size: 1.75rem; font-weight: 800; color: var(--success);">Rp 0</div>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="index.php?page=transaksi" class="btn btn-primary" style="display: block; text-align: center; text-decoration: none;">Proses Transaksi</a>
            <p style="font-size: 0.75rem; color: var(--text-muted); text-align: center; line-height: 1.4;">Saldo ini bersifat privat. Harap berikan informasi hanya kepada pemilik akun.</p>
        </div>
    </div>

    <div class="card" id="balance_empty_state" style="height: fit-content; text-align: center; padding: 4rem 1rem; color: var(--text-muted);">
        <div style="margin-bottom: 1.5rem; color: #cbd5e1;">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <h4 style="margin: 0 0 0.5rem; color: var(--text-main);">Belum Ada Mahasiswa Dipilih</h4>
        <p style="font-size: 0.875rem; max-width: 250px; margin: 0 auto;">Pilih nama mahasiswa dari daftar di samping untuk melihat informasi saldo secara mendetail.</p>
    </div>
</div>

<script>
document.getElementById('student_search').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#student_table tbody tr');
    
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

function showStudentDetail(name, npm, balance) {
    document.getElementById('balance_empty_state').style.display = 'none';
    document.getElementById('balance_detail_card').style.display = 'block';
    
    document.getElementById('detail_name').innerText = name;
    document.getElementById('detail_npm').innerText = 'NPM: ' + npm;
    document.getElementById('detail_balance').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(balance);
    
    const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
    document.getElementById('detail_avatar').innerText = initials;

    document.querySelectorAll('.student-row').forEach(r => {
        r.style.background = '';
        r.style.color = '';
    });
    event.currentTarget.style.background = 'var(--primary)';
    event.currentTarget.style.color = 'white';
}
</script>
