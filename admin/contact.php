<?php
require_once '../config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

// Холбоо барих мэдээлэл шинэчлэх
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_contact'])) {
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Хэрэв өмнө нь байсан бол шинэчлэх, байхгүй бол оруулах
    $stmt = $pdo->prepare("SELECT id FROM contact_info LIMIT 1");
    $stmt->execute();
    $exists = $stmt->fetch();

    if ($exists) {
        $stmt = $pdo->prepare("UPDATE contact_info SET email = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->execute([$email, $phone, $address, $exists['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO contact_info (email, phone, address) VALUES (?, ?, ?)");
        $stmt->execute([$email, $phone, $address]);
    }

    $success = "Холбоо барих мэдээлэл амжилттай шинэчлэгдлээ!";
}

// Одоогийн мэдээллийг авах
$stmt = $pdo->query("SELECT * FROM contact_info LIMIT 1");
$contact = $stmt->fetch(PDO::FETCH_ASSOC) ?? ['email' => '', 'phone' => '', 'address' => ''];
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Холбоо барих удирдах</title>
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
                <a href="skills.php" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">🛠️ Үр чадвар</a>
                <a href="projects.php" class="block px-6 py-4 rounded-2xl hover:bg-blue-600">📝 Төсөл</a>
                <a href="contact.php" class="block px-6 py-4 rounded-2xl bg-blue-600">📞 Холбоо барих</a>
                <a href="logout.php" class="block px-6 py-4 rounded-2xl hover:bg-red-600">🚪 Гарах</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-12">
            <h1 class="text-4xl font-bold text-[#001a33] mb-8">📞 Холбоо барих мэдээлэл удирдах</h1>

            <?php if (isset($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl mb-8">
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-3xl shadow p-10 max-w-2xl">
                <form method="POST">
                    <div class="mb-8">
                        <label class="block text-lg font-medium mb-3">И-мэйл хаяг</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($contact['email']) ?>" 
                               class="w-full px-6 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 text-lg">
                    </div>

                    <div class="mb-8">
                        <label class="block text-lg font-medium mb-3">Утасны дугаар</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($contact['phone']) ?>" 
                               class="w-full px-6 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 text-lg">
                    </div>

                    <div class="mb-8">
                        <label class="block text-lg font-medium mb-3">Хаяг / Байршил</label>
                        <textarea name="address" rows="4"
                                  class="w-full px-6 py-4 border border-gray-300 rounded-3xl focus:outline-none focus:border-blue-500 text-lg"><?= htmlspecialchars($contact['address']) ?></textarea>
                    </div>

                    <button type="submit" name="update_contact"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-3xl text-xl font-semibold transition">
                        ХАДГАЛАХ
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>