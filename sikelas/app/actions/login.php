<?php
require_once __DIR__ . '/../core/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npm = $_POST['npm'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT u.*, a.account_id FROM users u JOIN accounts a ON u.id = a.user_id WHERE u.npm = ?");
    $stmt->execute([$npm]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['account_id'] = $user['account_id'];
        $_SESSION['npm'] = $user['npm'];

        writeLog($pdo, $user['id'], "LOGIN", "users", $user['id'], "User logged in");

        header("Location: ../../index.php");
        exit;
    } else {
        header("Location: ../../index.php?error=Invalid credentials");
        exit;
    }
} else {
    header("Location: ../../index.php");
    exit;
}
?>
