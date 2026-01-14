<?php
$page = $_GET['page'] ?? 'overview';

// Map allowed pages to files
$allowed_pages = [
    'overview' => 'views/admin/overview.php',
    'mahasiswa' => 'views/admin/mahasiswa.php',
    'transaksi' => 'views/admin/transaksi.php',
    'rekap' => 'views/admin/rekap.php',
    'logs' => 'views/admin/logs.php',
    'registrasi' => 'views/admin/registrasi.php',
    'cek_saldo' => 'views/admin/cek_saldo.php'
];

$view_file = $allowed_pages[$page] ?? 'views/admin/overview.php';
?>

<div class="admin-container">
    <?php include 'views/layouts/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'views/layouts/header.php'; ?>

        <div class="page-container">
            <?php 
            if (file_exists($view_file)) {
                include $view_file;
            } else {
                echo "<h2>Halaman tidak ditemukan.</h2>";
            }
            ?>
        </div>
    </div>
</div>

<style>
/* Adjust form column to be vertical on single page context */
.forms-column .card {
    margin-bottom: 2rem;
}

/* Print Specific for Rekap */
@media print {
    .sidebar { display: none; }
    .main-content { margin-left: 0; padding: 0; }
    .card { box-shadow: none; border: 1px solid #000; }
    .btn { display: none; }
}
</style>
