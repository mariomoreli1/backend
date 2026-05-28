<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Блог</title>
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

    h1 {
        font-size: 2rem;
        margin-bottom: 30px;
        border-bottom: 2px solid saddlebrown;
        padding-bottom: 10px;
        color: #1a1a1a;
    }

    .article-card {
        background: #fff;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        transition: box-shadow 0.2s;
    }

    .article-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.13);
    }

    .article-card h2 {
        font-size: 1.3rem;
        margin-bottom: 10px;
    }

    .article-card h2 a {
        color: saddlebrown;
        text-decoration: none;
    }

    .article-card h2 a:hover {
        text-decoration: underline;
    }

    .article-card p {
        color: #555;
        line-height: 1.6;
        font-size: 0.97rem;
    }
</style>
</head>
<body>
<div class="container">

    <h1>Статьи</h1>

    <?php foreach ($articles as $article): ?>
        <div class="article-card">
            <h2>
                <a href="/articles/<?= $article->getId() ?>">
                    <?= $article->getName() ?>
                </a>
            </h2>
            <p><?= $article->getText() ?></p>
        </div>
    <?php endforeach; ?>

</div>
</body>
</html>