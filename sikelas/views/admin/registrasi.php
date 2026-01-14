<div style="margin-bottom: 2.5rem;">
    <h2 style="font-size: 1.875rem;">Tambah Mahasiswa Baru</h2>
    <p style="color: var(--text-muted);">Daftarkan anggota kelas baru ke dalam sistem Sikelas.</p>
</div>

<div style="max-width: 600px;">
    <div class="card">
        <h3>Form Pendaftaran</h3>
        <p style="font-size: 0.8125rem; color: var(--text-muted); margin-bottom: 1.5rem;">Pastikan NPM benar karena akan digunakan sebagai ID login mahasiswa.</p>
        
        <form action="app/actions/add_student.php" method="POST">
            <div class="form-group">
                <label>NPM (8 Digit)</label>
                <input type="number" name="npm" required placeholder="Contoh: 243400xx" minLength="8">
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="username" required placeholder="Masukkan nama lengkap mahasiswa">
            </div>
            <div class="form-group">
                <label>Password Awal</label>
                <input type="password" name="password" required placeholder="••••••••" value="password123">
                <small style="color: var(--text-muted);">Default: password123 (Mahasiswa dapat mengubahnya nanti)</small>
            </div>
            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Daftarkan Mahasiswa</button>
                <a href="index.php?page=mahasiswa" class="btn" style="background: #f1f5f9; color: var(--text-main); text-decoration: none; display: flex; align-items: center; justify-content: center;">Batal</a>
            </div>
        </form>
    </div>
</div>
