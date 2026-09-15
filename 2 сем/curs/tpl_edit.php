<?php require __DIR__ . '/layout.php'; layoutStart('Редактировать статью'); ?>

<a href="/articles/<?= $article->getId() ?>" class="back-link">Назад</a>

<div class="form-card">
    <h1 class="form-title">Редактировать статью</h1>

    <form method="post" action="/articles/<?= $article->getId() ?>/edit">
        <div class="field">
            <label for="name">Название</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($article->getName()) ?>">
        </div>

        <div class="field">
            <label for="text">Текст статьи</label>
            <textarea id="text" name="text" rows="12"><?= htmlspecialchars($article->getText()) ?></textarea>
        </div>

        <button type="submit" class="btn btn-save">Сохранить</button>
    </form>
</div>

<?php layoutEnd(); ?>
