<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title><?= $article->getName() ?></title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: Georgia, serif;
        background: #f5f0eb;
        color: #2c2c2c;
        padding: 40px 20px;
    }

    .container {
        max-width: 700px;
        margin: 0 auto;
    }

    .back {
        display: inline-block;
        margin-bottom: 24px;
        color: saddlebrown;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .back:hover { text-decoration: underline; }

    .card {
        background: #fff;
        border-radius: 8px;
        padding: 36px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    }

    h1 {
        font-size: 1.8rem;
        margin-bottom: 10px;
        color: #1a1a1a;
    }

    .author {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 24px;
    }

    .author span {
        color: saddlebrown;
        font-weight: bold;
    }

    .text {
        line-height: 1.8;
        font-size: 1rem;
        color: #444;
        margin-bottom: 30px;
    }

    .edit-link {
        display: inline-block;
        padding: 8px 20px;
        background: saddlebrown;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .edit-link:hover { background: black; }
</style>
</head>
<body>
<div class="container">

    <a href="/" class="back">Назад</a>

    <div class="card">
        <h1><?= $article->getName() ?></h1>
        <p class="author">Автор: <span><?= $author->getNickname() ?></span></p>
        <p class="text"><?= $article->getText() ?></p>
    </div>

</div>
</body>
</html>