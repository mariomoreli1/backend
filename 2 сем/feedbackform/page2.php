<?php
$headers = get_headers("https://www.php.net", 1);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Страница 2</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<header>
    <img src="logo_serrv.jpg" alt="МосПолитех" width="80">
    <h1>Результат get_headers</h1>
</header>

<main>
    <textarea rows="20" cols="80" readonly><?php print_r($headers); ?></textarea>
    <br><br>
    <a href="index.php">← Назад</a>
</main>

<footer>
    <p>задание для самостоятельной работы</p>
</footer>

</body>
</html>