<?php
require_once '../config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

// Төсөл нэмэх
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if ($title && $description) {
        $stmt = $pdo->prepare("INSERT INTO projects (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
        $success = "Төсөл амжилттай нэмэгдлээ!";
    } else {
        $error = "Төслийн нэр болон тайлбарыг бөглөнө үү!";
    }
}

// Төсөл устгах
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $success = "Төсөл устгагдлаа!";
}

// Бүх төслүүдийг авах
$stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Төсөл удирдах</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-72 bg-[#001a33] text-white p-8">
            <h2 class="text-3xl font-bold mb-12">🔧 Admin</h2>
            <nav class="space-y-2">
                <a href="index.php" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">🏠 Dashboard</a>
                <a href="sections.php" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">📋 Цэс удирдах</a>
                <a href="projects.php" class="block px-6 py-4 rounded-2xl bg-blue-600">📝 Төсөл удирдах</a>
                <a href="../index.php" target="_blank" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">🌐 Вэб харах</a>
                <a href="logout.php" class="block px-6 py-4 rounded-2xl hover:bg-red-600">🚪 Гарах</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-10 overflow-auto">
            <h1 class="text-4xl font-bold text-[#001a33] mb-8">📝 Төсөл / Мэдээ удирдах</h1>

            <?php if (isset($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl mb-6">
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-6">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <!-- Төсөл нэмэх форм -->
            <div class="bg-white rounded-3xl shadow p-8 mb-10">
                <h2 class="text-2xl font-semibold mb-6">Шинэ төсөл нэмэх</h2>
                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Төслийн нэр</label>
                        <input type="text" name="title" required 
                               class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Тайлбар (Description)</label>
                        <textarea name="description" rows="5" required
                                  class="w-full px-5 py-4 border border-gray-300 rounded-3xl focus:outline-none focus:border-blue-500"></textarea>
                    </div>
                    <button type="submit" name="add_project"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-semibold">
                        Төсөл нэмэх
                    </button>
                </form>
            </div>

            <!-- Төслүүдийн жагсаалт -->
            <div class="bg-white rounded-3xl shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-[#001a33] text-white">
                        <tr>
                            <th class="px-8 py-5 text-left">Төслийн нэр</th>
                            <th class="px-8 py-5 text-left">Тайлбар</th>
                            <th class="px-8 py-5 text-left">Огноо</th>
                            <th class="px-8 py-5 text-center">Үйлдэл</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-8 py-6 font-medium"><?= htmlspecialchars($project['title']) ?></td>
                            <td class="px-8 py-6 text-gray-600"><?= nl2br(htmlspecialchars(substr($project['description'], 0, 150))) ?>...</td>
                            <td class="px-8 py-6 text-gray-500"><?= $project['created_at'] ?></td>
                            <td class="px-8 py-6 text-center">
                                <a href="?delete=<?= $project['id'] ?>" 
                                   onclick="return confirm('Энэ төслийг устгах уу?')"
                                   class="text-red-600 hover:text-red-700 font-medium">
                                    Устгах
                                </a>
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