<?php
date_default_timezone_set('Europe/Moscow');
$name = "Арсений";
$hour = date('H'); 

if ($hour >= 5 && $hour < 12) {
    $greeting = "Доброе утро";
} elseif ($hour >= 12 && $hour < 18) {
    $greeting = "Добрый день";
} elseif ($hour >= 18 && $hour < 22) {
    $greeting = "Добрый вечер";
} else {
    $greeting = "Доброй ночи";
}

$message = "$greeting, " . $name . "!";

$current_time = date("H:i:s");    
$current_date = date("d.m.Y");      

$phrases = [
    "1 лабораторная серверная разработка",
    "лаба hello world",
    "1 лаба"
];

$random_phrase = $phrases[array_rand($phrases)];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo_serrv.jpg" alt="Логотип" class="logo">
        <div class="title"><h1>«Hello, World!»</h1></div>
    </header>

    <main>
        <div class="greeting-box">
            <h2><?= $message ?></h2>
            <p><strong><?= $random_phrase ?></strong></p>
            <div class="info">
                <p>Дата: <span class="datetime"><?= $current_date ?></span></p>
                <p>Время: <span class="datetime"><?= $current_time ?></span></p>
                
            </div>
        </div>
    </main>

    <footer>
        задание для самостоятельной работы
    </footer>
</body>
</html>