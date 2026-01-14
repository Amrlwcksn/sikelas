<?php
require_once 'config/database.php';

$npm = 12345;
$username = 'admin';
$password = 'admin123';
$role = 'pengurus';
$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo->beginTransaction();

    // Insert user
    $stmt = $pdo->prepare("INSERT INTO users (npm, username, password_hash, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$npm, $username, $password_hash, $role]);
    $user_id = $pdo->lastInsertId();

    // Create account
    $stmt = $pdo->prepare("INSERT INTO accounts (user_id) VALUES (?)");
    $stmt->execute([$user_id]);

    $pdo->commit();
    echo "Initial user 'admin' created successfully.\n";
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Error: " . $e->getMessage() . "\n";
}
?>
