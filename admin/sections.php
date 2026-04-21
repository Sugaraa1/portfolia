<?php
require_once '../config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

// Цэс нэмэх
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_section'])) {
    $title = trim($_POST['title']);
    $slug  = trim($_POST['slug']);
    $sort_order = (int)$_POST['sort_order'];

    if ($title && $slug) {
        try {
            $stmt = $pdo->prepare("INSERT INTO sections (title, slug, sort_order) VALUES (?, ?, ?)");
            $stmt->execute([$title, $slug, $sort_order]);
            $success = "Цэс амжилттай нэмэгдлээ!";
        } catch (Exception $e) {
            $error = "Алдаа: " . $e->getMessage();
        }
    } else {
        $error = "Цэсний нэр болон slug талбарыг бөглөнө үү!";
    }
}

// Цэс устгах
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM sections WHERE id = ?");
    $stmt->execute([$id]);
    $success = "Цэс устгагдлаа!";
}

// Бүх цэсүүдийг авах
$stmt = $pdo->query("SELECT * FROM sections ORDER BY sort_order ASC");
$sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Цэс удирдах</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-72 bg-[#001a33] text-white p-8">
            <h2 class="text-3xl font-bold mb-12">🔧 Admin</h2>
            <nav class="space-y-2">
                <a href="index.php" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">🏠 Dashboard</a>
                <a href="sections.php" class="block