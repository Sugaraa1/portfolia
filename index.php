<?php
require_once 'config.php';

// Цэсүүдийг авах
$sections = $pdo->query("SELECT * FROM sections WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll(PDO::FETCH_ASSOC);

// Үр чадваруудыг авах
$skills = $pdo->query("SELECT * FROM skills ORDER BY sort_order ASC")->fetchAll(PDO::FETCH_ASSOC);

// Төслүүдийг авах
$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Холбоо барих мэдээлэл авах
$contact = $pdo->query("SELECT * FROM contact_info LIMIT 1")->fetch(PDO::FETCH_ASSOC) ?? 
           ['email' => 'tanyner@example.com', 'phone' => '+976 99112233', 'address' => 'Улаанбаатар, Монгол'];
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Миний Вэб Сайт</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: system-ui, sans-serif; }
        .nav-link { transition: all 0.3s; }
        .nav-link:hover { color: #facc15; transform: translateY(-2px); }
        .skill-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(250, 204, 21, 0.2); }
        .project-card:hover { transform: translateY(-10px); }
    </style>
</head>
<body class="bg-[#0a1428] text-white">

    <!-- NAV -->
    <nav class="bg-[#001a33] border-b border-yellow-400 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-yellow-400 rounded-2xl flex items-center justify-center text-[#001a33] font-bold text-3xl">M</div>
                <h1 class="text-2xl font-semibold tracking-tight">Миний Вэб</h1>
            </div>

            <div class="flex gap-9 text-lg font-medium">
                <?php foreach ($sections as $sec): ?>
                    <a href="#<?= htmlspecialchars($sec['slug']) ?>" class="nav-link"><?= htmlspecialchars($sec['title']) ?></a>
                <?php endforeach; ?>
            </div>

            <a href="admin/index.php" class="bg-yellow-400 hover:bg-amber-300 text-[#001a33] px-6 py-3 rounded-2xl font-semibold flex items-center gap-2 transition">
                ⚙️ Админ
            </a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="bg-[#001a33] py-32 text-center">
        <h1 class="text-7xl font-bold text-yellow-400 mb-6">Сайн уу!</h1>
        <p class="text-3xl text-gray-300 max-w-2xl mx-auto">Миний үр чадвар, бүтээсэн төслүүд болон холбоо барих мэдээллийг эндээс харна уу.</p>
    </section>

    <!-- ДИНАМИК ЦЭСҮҮД -->
    <?php foreach ($sections as $section): ?>
        <section id="<?= htmlspecialchars($section['slug']) ?>" class="py-20">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-5xl font-bold text-yellow-400 text-center mb-16">
                    <?= htmlspecialchars($section['title']) ?>
                </h2>

                <?php if ($section['slug'] === 'skills' && $skills): ?>
                    <!-- Үр чадварын хэсэг -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                        <?php foreach ($skills as $skill): ?>
                        <div class="skill-card bg-[#112233] border border-yellow-400/30 rounded-3xl p-10 text-center transition-all">
                            <p class="text-3xl font-semibold text-yellow-400"><?= htmlspecialchars($skill['skill_name']) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>

                <?php elseif ($section['slug'] === 'projects' && $projects): ?>
                    <!-- Төслүүдийн хэсэг -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php foreach ($projects as $project): ?>
                        <div class="project-card bg-[#112233] rounded-3xl overflow-hidden transition-all">
                            <div class="h-64 bg-gradient-to-br from-yellow-400/10 to-transparent flex items-center justify-center text-7xl border-b border-yellow-400/20">
                                💼
                            </div>
                            <div class="p-8">
                                <h3 class="text-2xl font-semibold text-yellow-400 mb-4"><?= htmlspecialchars($project['title']) ?></h3>
                                <p class="text-gray-300 leading-relaxed"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                <?php elseif ($section['slug'] === 'contact'): ?>
                    <!-- Холбоо барих хэсэг -->
                    <div class="max-w-2xl mx-auto bg-[#112233] rounded-3xl p-16 text-center">
                        <h3 class="text-3xl font-semibold mb-8 text-yellow-400">Холбоо барих</h3>
                        <div class="space-y-6 text-lg">
                            <?php if ($contact['email']): ?>
                                <p><strong>И-мэйл:</strong> <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="text-yellow-400 hover:underline"><?= htmlspecialchars($contact['email']) ?></a></p>
                            <?php endif; ?>
                            <?php if ($contact['phone']): ?>
                                <p><strong>Утас:</strong> <?= htmlspecialchars($contact['phone']) ?></p>
                            <?php endif; ?>
                            <?php if ($contact['address']): ?>
                                <p><strong>Хаяг:</strong> <?= nl2br(htmlspecialchars($contact['address'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Бусад цэсүүд -->
                    <div class="bg-[#112233] rounded-3xl p-20 text-center">
                        <p class="text-2xl text-gray-400"><?= htmlspecialchars($section['title']) ?> хэсэг</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>

    <!-- FOOTER -->
    <footer class="bg-[#001a33] py-12 border-t border-yellow-400/30">
        <div class="max-w-7xl mx-auto px-6 text-center text-yellow-400/70">
            © <?= date("Y") ?> Миний Вэб Сайт • Лабораторийн ажил №11
        </div>
    </footer>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>