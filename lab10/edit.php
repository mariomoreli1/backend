<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Редактировать</title>
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
        font-size: 1.6rem;
        margin-bottom: 28px;
        color: #1a1a1a;
        border-bottom: 2px solid saddlebrown;
        padding-bottom: 10px;
    }

    label {
        display: block;
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 6px;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: Georgia, serif;
        font-size: 1rem;
        color: #2c2c2c;
        background: #fdfaf6;
        margin-bottom: 20px;
        outline: none;
        transition: border 0.2s;
    }

    input[type="text"]:focus,
    textarea:focus {
        border-color: saddlebrown;
    }

    textarea { resize: vertical; min-height: 180px; }

    button {
        padding: 10px 28px;
        background: saddlebrown;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
    }

    button:hover { background: saddlebrown; }
</style>
</head>
<body>
<div class="container">

    <a href="/articles/<?= $article->getId() ?>" class="back">Назад</a>

    <div class="card">
        <h1>Редактировать статью</h1>

        <form method="post" action="/articles/<?= $article->getId() ?>/edit">
            <label>Название</label>
            <input type="text" name="name" value="<?= $article->getName() ?>">

            <label>Текст</label>
            <textarea name="text"><?= $article->getText() ?></textarea>

            <button type="submit">Сохранить</button>
        </form>
    </div>

</div>
</body>
</html>