<?php require __DIR__ . '/layout.php'; layoutStart('Калькулятор чтения'); ?>

<div class="form-card">
    <h1 class="form-title">Калькулятор времени чтения</h1>
    <p class="form-desc">Вставьте текст статьи и узнайте, сколько времени займёт её прочтение.</p>

    <form method="post" action="/calculator">
        <div class="field">
            <label for="text">Текст для анализа</label>
            <textarea id="text" name="text" rows="10" placeholder="Вставьте сюда текст статьи..."><?= htmlspecialchars($_POST['text'] ?? '') ?></textarea>
        </div>

        <div class="field">
            <label for="speed">Скорость чтения (слов в минуту)</label>
            <input type="number" id="speed" name="speed" value="<?= (int)($_POST['speed'] ?? 200) ?>" min="50" max="1000">
            <span class="field-hint">Средняя скорость — 200 слов/мин</span>
        </div>

        <button type="submit" class="btn btn-save">Рассчитать</button>
    </form>

    <?php if ($result !== null): ?>
    <div class="calc-result">
        <h2>Результат</h2>
        <div class="result-grid">
            <div class="result-item">
                <span class="result-num"><?= $result['words'] ?></span>
                <span class="result-label">слов в тексте</span>
            </div>
            <div class="result-item">
                <span class="result-num"><?= $result['speed'] ?></span>
                <span class="result-label">слов/мин скорость</span>
            </div>
            <div class="result-item highlight">
                <span class="result-num"><?= $result['minutes'] ?></span>
                <span class="result-label">минут на чтение</span>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php layoutEnd(); ?>
