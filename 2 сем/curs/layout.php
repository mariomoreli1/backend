<?php
function layoutStart(string $title = 'Блог'): void { ?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title) ?> — Курсовой проект php</title>
<link rel="stylesheet" href="/style.css">
</head>
<body>
<nav class="navbar">
    <a href="/" class="brand">Серверная разработка</a>
    <div class="nav-links">
        <a href="/">Главная</a>
        <a href="/calculator">Калькулятор</a>
        <a href="/contacts">Контакты</a>
    </div>
</nav>
<main class="container">
<?php }

function layoutEnd(): void { ?>
</main>
<footer class="footer">
    <p>© <?= date('Y') ?> курсовой проект по серверной разработке</p>
</footer>
</body>
</html>
<?php }
