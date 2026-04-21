<?php
require_once 'config.php';

echo "<h1 style='color:green;'>✅ Config.php амжилттай ачааллагдлаа!</h1>";

try {
    $stmt = $pdo->query("SELECT 1");
    echo "<p style='color:green; font-size:20px;'>🎉 PDO холболт БҮРЭН АЖИЛЛАЖ байна!</p>";
    
    // Database-д байгаа хүснэгтүүдийг шалгах
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Одоо байгаа хүснэгтүүд: <strong>" . implode(', ', $tables) . "</strong></p>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>Алдаа: " . $e->getMessage() . "</p>";
}
?>