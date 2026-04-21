<?php
require_once '../config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-72 bg-[#001a33] text-white p-8">
            <h2 class="text-3xl font-bold mb-12">🔧 Admin Удирдлага</h2>
            
            <nav class="space-y-3">
                <a href="index.php" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-blue-600 text-white">
                    🏠 Dashboard
                </a>
                <a href="sections.php" class="flex items-center gap-3 px-6 py-4 rounded-2xl hover:bg-blue-600 transition">
                    📋 Цэс удирдах
                </a>
                <a href="skills.php" class="flex items-center gap-3 px-6 py-4 rounded-2xl hover:bg-blue-600 transition">
                    🛠️ Үр чадвар
                </a>
                <a href="projects.php" class="flex items-center gap-3 px-6 py-4 rounded-2xl hover:bg-blue-600 transition">
                    📝 Төсөл удирдах
                </a>
                <a href="contact.php" class="flex items-center gap-3 px-6 py-4 rounded-2xl hover:bg-blue-600 transition">
                    📞 Холбоо барих
                </a>
                <a href="../index.php" target="_blank" class="flex items-center gap-3 px-6 py-4 rounded-2xl hover:bg-blue-600 transition">
                    🌐 Вэб хуудсыг харах
                </a>
                <a href="logout.php" class="flex items-center gap-3 px-6 py-4 rounded-2xl hover:bg-red-600 transition text-red-400">
                    🚪 Гарах
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-12">
            <div class="max-w-4xl">
                <h1 class="text-6xl font-bold text-[#001a33] mb-6">Сайн байна уу, Админ!</h1>
                <p class="text-2xl text-gray-600 mb-12">Та вэб сайтаа эндээс бүрэн удирдаж болно.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white p-10 rounded-3xl shadow hover:shadow-xl transition">
                        <h3 class="text-3xl font-semibold mb-4">📋 Цэс удирдах</h3>
                        <p class="text-gray-600">Вэб дээрх гол цэсүүдийг нэмэх, засах, устгах</p>
                    </div>
                    <div class="bg-white p-10 rounded-3xl shadow hover:shadow-xl transition">
                        <h3 class="text-3xl font-semibold mb-4">🛠️ Үр чадвар удирдах</h3>
                        <p class="text-gray-600">HTML, CSS, PHP гэх мэт чадваруудаа удирдах</p>
                    </div>
                    <div class="bg-white p-10 rounded-3xl shadow hover:shadow-xl transition">
                        <h3 class="text-3xl font-semibold mb-4">📝 Төсөл удирдах</h3>
                        <p class="text-gray-600">Бүтээсэн төслүүдээ нэмэх, устгах</p>
                    </div>
                    <div class="bg-white p-10 rounded-3xl shadow hover:shadow-xl transition">
                        <h3 class="text-3xl font-semibold mb-4">📞 Холбоо барих</h3>
                        <p class="text-gray-600">И-мэйл, утас, хаягаа шинэчлэх</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>