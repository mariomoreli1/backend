<?php require __DIR__ . '/layout.php'; layoutStart($article->getName()); ?>

<a href="/" class="back-link">Назад</a>

<article class="article-full">
    <h1 class="article-title"><?= htmlspecialchars($article->getName()) ?></h1>

    <div class="article-meta">
        <?php if ($author): ?>
            <span><?= htmlspecialchars($author->getNickname()) ?></span>
        <?php endif; ?>
    </div>

    <div class="article-body">
        <?= nl2br(htmlspecialchars($article->getText())) ?>
    </div>

    <a href="/articles/<?= $article->getId() ?>/edit" class="btn btn-edit">Редактировать</a>
</article>

<?php layoutEnd(); ?>
