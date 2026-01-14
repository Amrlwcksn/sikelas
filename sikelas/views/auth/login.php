<div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background: #f1f5f9; padding: 1.5rem;">
    <div class="card" style="max-width: 450px; width: 100%; padding: 3rem; border-radius: 1.5rem;">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: #eff6ff; border-radius: 1rem; color: var(--primary); margin-bottom: 1rem;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <h1 style="font-size: 2rem; -webkit-text-fill-color: initial; color: var(--primary); margin-bottom: 0.25rem;">Sikelas.</h1>
            <p style="font-size: 0.875rem; color: var(--text-muted);">Silakan masuk untuk akses keuangan kelas</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div style="background: #fef2f2; color: var(--danger); padding: 0.8rem; border-radius: 0.75rem; margin-bottom: 1.5rem; font-size: 0.8125rem; font-weight: 500; border: 1px solid #fee2e2;">
                ⚠️ <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="app/actions/login.php" method="POST">
            <div style="margin-bottom: 1.25rem;">
                <label style="font-weight: 600; color: var(--text-main);">NPM (8 Digit)</label>
                <input type="number" name="npm" required placeholder="Contoh: 243340xx" style="margin-top: 0.5rem;">
            </div>
            <div style="margin-bottom: 2rem;">
                <label style="font-weight: 600; color: var(--text-main);">Password</label>
                <input type="password" name="password" required placeholder="••••••••" style="margin-top: 0.5rem;">
            </div>
            <button type="submit" class="btn btn-primary">Masuk ke Dashboard</button>
        </form>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); text-align: center;">
            <p style="font-size: 0.75rem; color: var(--text-muted);">Butuh bantuan? Hubungi Ketua Kelas atau Pengurus Kas.</p>
        </div>
    </div>
</div>
