<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">

    <title>
        <?= $title ?? 'Мой блог' ?>
    </title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>
        <?= $content ?>
    </h1>

    <hr>

    <a href="/">
        <button>Главная</button>
    </a>

    <a href="/hello/Иван">
        <button>Привет</button>
    </a>

    <a href="/bye/Иван">
        <button>Пока</button>
    </a>

</body>
</html>