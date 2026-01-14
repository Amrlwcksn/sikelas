<?php
session_start();
require_once __DIR__ . '/../config/database.php';

/**
 * Get the current balance for a specific account.
 */
function getAccountBalance($pdo, $account_id) {
    $stmt = $pdo->prepare("
        SELECT 
            COALESCE(SUM(CASE WHEN jenis = 'setor' THEN jumlah ELSE 0 END), 0) -
            COALESCE(SUM(CASE WHEN jenis = 'keluar' THEN jumlah ELSE 0 END), 0) AS balance
        FROM transactions
        WHERE account_id = ?
    ");
    $stmt->execute([$account_id]);
    $row = $stmt->fetch();
    return (float) ($row['balance'] ?? 0);
}

/**
 * Get total class cash (Total Setor - Total Keluar)
 */
function getClassTotalCash($pdo) {
    $stmt = $pdo->query("
        SELECT 
            COALESCE(SUM(CASE WHEN jenis = 'setor' THEN jumlah ELSE 0 END), 0) -
            COALESCE(SUM(CASE WHEN jenis = 'keluar' THEN jumlah ELSE 0 END), 0) AS total
        FROM transactions
    ");
    return (float) ($stmt->fetch()['total'] ?? 0);
}

/**
 * Record a log entry.
 */
function writeLog($pdo, $user_id, $action, $target_type = null, $target_id = null, $detail = null) {
    try {
        $stmt = $pdo->prepare("INSERT INTO logs (user_id, action, target_type, target_id, detail) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $action, $target_type, $target_id, $detail]);
    } catch (Exception $e) {
        // Log rotation or fail silently if database log fails
        error_log("Failed to write log: " . $e->getMessage());
    }
}

/**
 * Check if the current user is logged in.
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if the current user has the 'pengurus' role.
 */
function isPengurus() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'pengurus';
}

/**
 * Format currency to IDR.
 */
function formatIDR($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

/**
 * Add a transaction with negative balance prevention.
 */
function addTransaction($pdo, $account_id, $jenis, $jumlah, $keterangan, $created_by, $tanggal = null) {
    // Validation: amount must be positive
    if ($jumlah <= 0) {
        return ['status' => 'error', 'message' => 'Jumlah harus lebih besar dari 0.'];
    }

    // Validation: prevent negative balance if it's 'keluar'
    if ($jenis === 'keluar') {
        $currentBalance = getAccountBalance($pdo, $account_id);
        if ($currentBalance < $jumlah) {
            return ['status' => 'error', 'message' => 'Saldo tidak mencukupi untuk melakukan penarikan.'];
        }
    }

    try {
        $pdo->beginTransaction();

        $sql = "INSERT INTO transactions (account_id, jenis, jumlah, keterangan, created_by" . ($tanggal ? ", tanggal" : "") . ") VALUES (?, ?, ?, ?, ?" . ($tanggal ? ", ?" : "") . ")";
        $params = [$account_id, $jenis, $jumlah, $keterangan, $created_by];
        if ($tanggal) $params[] = $tanggal;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $transaction_id = $pdo->lastInsertId();

        // Fetch NPM for clearer logging
        $stmt = $pdo->prepare("SELECT u.npm FROM users u JOIN accounts a ON u.id = a.user_id WHERE a.account_id = ?");
        $stmt->execute([$account_id]);
        $npm = $stmt->fetchColumn();

        writeLog($pdo, $created_by, "ADD_TRANSACTION", "transactions", $transaction_id, "Transaksi $jenis senilai $jumlah untuk Mahasiswa (NPM: $npm)" . ($tanggal ? " pada tanggal: $tanggal" : ""));

        $pdo->commit();
        return ['status' => 'success', 'message' => 'Transaksi berhasil dicatat.'];
    } catch (Exception $e) {
        $pdo->rollBack();
        return ['status' => 'error', 'message' => 'Gagal mencatat transaksi: ' . $e->getMessage()];
    }
}
?>
