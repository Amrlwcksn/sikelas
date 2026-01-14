<?php
require_once 'config/database.php';

$npm = 2021002;
$username = 'mhs1';
$password = 'password123';
$role = 'mahasiswa';
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
    echo "Student 'mhs1' (NPM: 2021002) created successfully with password 'password123'.\n";
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Error: " . $e->getMessage() . "\n";
}
?>
