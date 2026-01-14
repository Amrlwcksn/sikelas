<?php
require_once __DIR__ . '/../core/functions.php';

if (!isLoggedIn() || !isPengurus()) {
    header("Location: ../../index.php?error=Unauthorized");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_id = $_POST['account_id'] ?? 0;
    $jenis = $_POST['jenis'] ?? '';
    $jumlah = $_POST['jumlah'] ?? 0;
    $keterangan = $_POST['keterangan'] ?? '';
    $tanggal = $_POST['tanggal'] ?? null;
    $created_by = $_SESSION['user_id'];

    $result = addTransaction($pdo, $account_id, $jenis, $jumlah, $keterangan, $created_by, $tanggal);

    if ($result['status'] === 'success') {
        header("Location: ../../index.php?page=transaksi&msg=" . urlencode($result['message']));
    } else {
        header("Location: ../../index.php?page=transaksi&err=" . urlencode($result['message']));
    }
    exit;
} else {
    header("Location: ../../index.php?page=transaksi");
    exit;
}
?>
