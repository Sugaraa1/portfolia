<?php
require_once '../config.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

// Skill нэмэх
if (isset($_POST['add_skill'])) {
    $name = trim($_POST['skill_name']);
    $order = (int)$_POST['sort_order'];
    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO skills (skill_name, sort_order) VALUES (?, ?)");
        $stmt->execute([$name, $order]);
        $success = "Үр чадвар нэмэгдлээ!";
    }
}

// Skill устгах
if (isset($_GET['delete_skill'])) {
    $id = (int)$_GET['delete_skill'];
    $pdo->prepare("DELETE FROM skills WHERE id = ?")->execute([$id]);
    $success = "Үр чадвар устгагдлаа!";
}

$skills = $pdo->query("SELECT * FROM skills ORDER BY sort_order ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Үр Чадвар Удирдах</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
    <div class="w-72 bg-[#001a33] text-white p-8">
        <h2 class="text-3xl font-bold mb-12">Admin</h2>
        <nav class="space-y-2">
            <a href="index.php" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">Dashboard</a>
            <a href="sections.php" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">Цэс удирдах</a>
            <a href="skills.php" class="block px-6 py-4 rounded-2xl bg-blue-600">Миний үр чадвар</a>
            <a href="projects.php" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">Төсөл удирдах</a>
            <a href="contact.php" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">Холбоо барих</a>
            <a href="logout.php" class="block px-6 py-4 rounded-2xl hover:bg-red-600">Гарах</a>
        </nav>
    </div>

    <div class="flex-1 p-10">
        <h1 class="text-4xl font-bold mb-8">🛠️ Миний Үр Чадвар Удирдах</h1>

        <?php if(isset($success)): ?>
            <div class="bg-green-100 p-4 rounded-2xl mb-6"><?= $success ?></div>
        <?php endif; ?>

        <!-- Нэмэх форм -->
        <div class="bg-white p-8 rounded-3xl shadow mb-10">
            <form method="POST" class="flex gap-4">
                <input type="text" name="skill_name" placeholder="Үр чадварын нэр (жишээ: Python)" required
                       class="flex-1 px-6 py-4 border rounded-2xl">
                <input type="number" name="sort_order" value="10" placeholder="Дараалал" 
                       class="w-32 px-6 py-4 border rounded-2xl">
                <button type="submit" name="add_skill" 
                        class="bg-blue-600 text-white px-8 py-4 rounded-2xl">Нэмэх</button>
            </form>
        </div>

        <!-- Жагсаалт -->
        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-[#001a33] text-white">
                    <tr>
                        <th class="px-8 py-5 text-left">Үр чадвар</th>
                        <th class="px-8 py-5 text-left">Дараалал</th>
                        <th class="px-8 py-5 text-center">Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($skills as $skill): ?>
                    <tr class="border-t">
                        <td class="px-8 py-6"><?= htmlspecialchars($skill['skill_name']) ?></td>
                        <td class="px-8 py-6"><?= $skill['sort_order'] ?></td>
                        <td class="px-8 py-6 text-center">
                            <a href="?delete_skill=<?= $skill['id'] ?>" 
                               onclick="return confirm('Устгах уу?')" class="text-red-600">Устгах</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>