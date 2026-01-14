<?php
require_once __DIR__ . '/app/config/database.php';
$stmt = $pdo->prepare("UPDATE users SET npm = 243340000 WHERE role = 'pengurus'");
$stmt->execute();
echo "Admin NPM updated to 243340000";
