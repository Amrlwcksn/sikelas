<?php
require_once 'app/core/functions.php';

$page_title = "Sikela - Sistem Pencatatan Tabungan";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php if (!isLoggedIn()): ?>
    <?php include 'views/auth/login.php'; ?>
<?php else: ?>
    <?php 
    if (isPengurus()) {
        include 'views/admin/dashboard.php';
    } else {
        include 'views/student/dashboard.php';
    }
    ?>
<?php endif; ?>

</body>
</html>
