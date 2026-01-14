<header style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <div style="text-align: right;">
            <div style="font-weight: 700; font-size: 0.875rem;"><?php echo $_SESSION['username']; ?></div>
            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;"><?php echo $_SESSION['role']; ?></div>
        </div>
        <div style="width: 40px; height: 40px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #64748b; border: 2px solid white; box-shadow: var(--shadow);">
            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
        </div>
    </div>
</header>
