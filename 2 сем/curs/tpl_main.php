<?php require __DIR__ . '/layout.php'; layoutStart('Главная'); ?>

<div class="greeting-box">
    <div class="greeting-text">
        <span class="greeting-hi"><?= $greeting ?>!</span>
    </div>
    <p class="greeting-sub">Курсовой проект по серверной разработке</p>
</div>

<h2 class="section-title">Последние статьи</h2>

<?php if (empty($articles)): ?>
    <p class="empty">Статей пока нет.</p>
<?php else: ?>
    <div class="articles-grid">
        <?php foreach ($articles as $article): ?>
        <div class="card">
            <h3 class="card-title">
                <a href="/articles/<?= $article->getId() ?>"><?= htmlspecialchars($article->getName()) ?></a>
            </h3>
            <p class="card-text"><?= htmlspecialchars(mb_substr($article->getText(), 0, 150)) ?>...</p>
            <a href="/articles/<?= $article->getId() ?>" class="card-link">Читать →</a>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php layoutEnd(); ?>
