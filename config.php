<?php
// ====================== config.php ======================

$host = 'localhost:3307';
$db   = 'portfolio_db';     // Өөрийн   үүсгэсэн database нэр
$user = 'root';             // XAMPP-д ихэвчлэн root
$pass = '';                 // XAMPP-д ихэвчлэн хоосон

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    // Чухал тохиргоо
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // Холболт амжилттай бол энэ мессеж гарна
    // echo "✅ Database холболт амжилттай!";   // Туршилтын үед нээж болно

} catch (PDOException $e) {
    // Холболт амжилтгүй бол алдаа харуулна
    die("❌ Database холболт амжилтгүй боллоо: " . $e->getMessage());
}

// Session эхлүүлэх (admin panel-д хэрэгтэй)
session_start();
?>