<?php
require_once __DIR__ . '/../core/functions.php';

if (!isLoggedIn() || !isPengurus()) {
    header("Location: ../../index.php?error=Unauthorized");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npm = $_POST['npm'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = 'mahasiswa';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo->beginTransaction();

        // Check if NPM/Username exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE npm = ? OR username = ?");
        $stmt->execute([$npm, $username]);
        if ($stmt->fetch()) {
            throw new Exception("NPM atau Username sudah terdaftar.");
        }

        // Insert user
        $stmt = $pdo->prepare("INSERT INTO users (npm, username, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$npm, $username, $password_hash, $role]);
        $user_id = $pdo->lastInsertId();

        // Create account
        $stmt = $pdo->prepare("INSERT INTO accounts (user_id) VALUES (?)");
        $stmt->execute([$user_id]);

        writeLog($pdo, $_SESSION['user_id'], "ADD_USER", "users", $user_id, "Added student $username ($npm)");

        $pdo->commit();
        header("Location: ../../index.php?msg=Mahasiswa berhasil ditambahkan.");
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header("Location: ../../index.php?err=" . urlencode($e->getMessage()));
    }
    exit;
} else {
    header("Location: ../../index.php");
    exit;
}
?>
