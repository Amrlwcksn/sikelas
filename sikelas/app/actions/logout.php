<?php
require_once __DIR__ . '/../core/functions.php';

if (isLoggedIn()) {
    writeLog($pdo, $_SESSION['user_id'], "LOGOUT", "users", $_SESSION['user_id'], "User logged out");
}

session_unset();
session_destroy();
header("Location: ../../index.php");
exit;
?>
