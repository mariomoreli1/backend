<?php require __DIR__ . '/layout.php'; layoutStart('Контакты'); ?>

<h1 class="section-title">Обратная связь</h1>

<?php if ($success): ?>
    <div class="alert alert-success">Ваше сообщение отправлено! Спасибо.</div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?>
            <p><?= htmlspecialchars($e) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="two-col">
    <div class="form-card">
        <h2 class="form-title">Написать нам</h2>
        <form method="post" action="/contacts">
            <div class="field">
                <label for="name">Ваше имя *</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($form['name']) ?>" placeholder="Иван Иванов">
            </div>
            <div class="field">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($form['email']) ?>" placeholder="ivan@mail.ru">
            </div>
            <div class="field">
                <label for="message">Сообщение *</label>
                <textarea id="message" name="message" rows="5" placeholder="Ваше сообщение..."><?= htmlspecialchars($form['message']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-save">Отправить</button>
        </form>
    </div>

    <div class="contacts-list">
        <h2 class="form-title">Последние обращения</h2>
        <?php if (empty($contacts)): ?>
            <p class="empty">Обращений пока нет.</p>
        <?php else: ?>
            <?php foreach ($contacts as $c): ?>
            <div class="contact-item">
                <div class="contact-header">
                    <strong><?= htmlspecialchars($c->getName()) ?></strong>
                    <span class="contact-email"><?= htmlspecialchars($c->getEmail()) ?></span>
                </div>
                <p class="contact-msg"><?= htmlspecialchars(mb_substr($c->getMessage(), 0, 100)) ?><?= mb_strlen($c->getMessage()) > 100 ? '...' : '' ?></p>
                <span class="contact-date"><?= htmlspecialchars($c->getCreatedAt()) ?></span>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php layoutEnd(); ?>
