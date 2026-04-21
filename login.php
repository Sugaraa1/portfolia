<?php
require_once 'config.php';

if (isset($_SESSION['admin'])) {
    header('Location: admin/index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Нэвтрэх нэр болон нууц үгээ оруулна уу!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === $password) {   // Энгийн шалгалт
            $_SESSION['admin'] = true;
            header('Location: admin/index.php');
            exit;
        } else {
            $error = "Нэвтрэх нэр эсвэл нууц үг буруу байна!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нэвтрэх - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0a1428] min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md">
        <h1 class="text-4xl font-bold text-center mb-8 text-[#001a33]">Нэвтрэх</h1>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-6 text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <input type="text" name="username" value="admin" required
                       class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 text-lg"
                       placeholder="Нэвтрэх нэр">
            </div>
            
            <div>
                <input type="password" name="password" value="123456" required
                       class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 text-lg"
                       placeholder="Нууц үг">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-2xl text-xl transition">
                Нэвтрэх
            </button>
        </form>

        <div class="text-center mt-6 text-sm text-gray-500">
            Туршилт: <strong>admin</strong> / <strong>123456</strong>
        </div>
    </div>
</body>
</html>