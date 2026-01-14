<?php
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/core/functions.php';

try {
    $pdo->beginTransaction();

    // 1. Cleanup: Delete all non-admin users and linked data
    // We get admin id first to avoid deleting it
    $stmt = $pdo->query("SELECT id FROM users WHERE role = 'pengurus' LIMIT 1");
    $admin = $stmt->fetch();
    $adminId = $admin['id'];

    $pdo->exec("DELETE FROM logs");
    $pdo->exec("DELETE FROM transactions");
    $pdo->exec("DELETE FROM accounts WHERE user_id != $adminId");
    $pdo->exec("DELETE FROM users WHERE id != $adminId");

    echo "Cleanup complete. Reseting student data...<br>";

    // 2. Realistic Indonesian Names
    $names = [
        "Aditya Wijaya", "Budi Santoso", "Citra Lestari", "Dedi Kurniawan", "Eka Putri", 
        "Fajar Ramadhan", "Gita Permata", "Hendra Saputra", "Indah Sari", "Joko Susilo",
        "Kartika Dewi", "Lutfi Hakim", "Maya Sandria", "Naufal Aziz", "Olivia Zalianty",
        "Putu Gede", "Qori Ananda", "Rizky Pratama", "Siti Aminah", "Tegar Prasetya",
        "Utami Ningsih", "Vina Panduwinata", "Wawan Setiawan", "Xena Clarissa", "Yayan Ruhian",
        "Zaki Mubarok", "Aisyah Zahira", "Bambang Pamungkas", "Chandra Wijaya", "Dian Sastrowardoyo",
        "Eko Patrio"
    ];

    $month = date('m');
    $year = date('Y');
    $numDays = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);

    // 3. Create 31 Students & Accounts
    $npmStart = 24340001; // 8 Digits
    $students = [];

    // Update Admin NPM to 8 digits
    $pdo->prepare("UPDATE users SET npm = 24340000 WHERE role = 'pengurus'")->execute();

    foreach ($names as $index => $name) {
        $npm = $npmStart + $index;
        $username = strtolower(str_replace(' ', '', $name)) . $index;
        $password = password_hash('password123', PASSWORD_BCRYPT);
        
        $stmt = $pdo->prepare("INSERT INTO users (npm, username, password_hash, role) VALUES (?, ?, ?, 'mahasiswa')");
        $stmt->execute([$npm, $name, $password]);
        $userId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO accounts (user_id) VALUES (?)");
        $stmt->execute([$userId]);
        $accountId = $pdo->lastInsertId();

        $students[] = [
            'account_id' => $accountId,
            'name' => $name,
            'is_bolong' => ($index % 8 == 0) // Roughly 4 students will have missing payments
        ];
    }

    echo "31 Students created successfully.<br>";

    // 4. Simulate Transactions
    // Let's assume Kas is 5.000 per week, paid on specific days
    $weeks = [5, 12, 19, 26]; // Rough paydays
    $kasAmount = 5000;

    foreach ($students as $s) {
        foreach ($weeks as $wIndex => $day) {
            // Check if student skipped this week
            if ($s['is_bolong'] && $wIndex == 2) {
                continue; // Student 0, 8, 16, 24 skips the 3rd week
            }

            // Pay on the payday or a few days after
            $actualDay = min($numDays, $day + rand(0, 2));
            $tanggal = "$year-$month-$actualDay " . rand(10, 16) . ":00:00";
            
            $stmt = $pdo->prepare("INSERT INTO transactions (account_id, jenis, jumlah, keterangan, created_by, tanggal) VALUES (?, 'setor', ?, ?, ?, ?)");
            $stmt->execute([
                $s['account_id'],
                $kasAmount,
                "Kas Minggu ke-" . ($wIndex + 1),
                $adminId,
                $tanggal
            ]);
        }
    }

    echo "Full month transactions simulated.<br>";

    $pdo->commit();
    echo "<strong>Success!</strong> All demo data has been generated. <a href='index.php'>Go to Dashboard</a>";

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
?>
