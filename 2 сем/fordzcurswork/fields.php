<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_field') {
        $stmt = $pdo->prepare('INSERT INTO Field (name, description, data) VALUES (?, ?, NOW())');
        $stmt->execute([trim($_POST['name']), trim($_POST['description'])]);
        header('Location: fields.php');
        exit;
    }
    if ($_POST['action'] === 'delete_field') {
        $pdo->prepare('DELETE FROM Field_Hashtag WHERE id_field = ?')->execute([$_POST['field_id']]);
        $pdo->prepare('DELETE FROM Field WHERE id = ?')->execute([$_POST['field_id']]);
        header('Location: fields.php');
        exit;
    }
    if ($_POST['action'] === 'add_hashtag') {
        $name = ltrim(trim($_POST['hashtag_name']), '#');
        $stmt = $pdo->prepare('INSERT INTO Hashtag (name, data) VALUES (?, NOW())');
        $stmt->execute([$name]);
        $hashtag_id = $pdo->lastInsertId();
        $pdo->prepare('INSERT INTO Field_Hashtag (id_hashtag, id_field) VALUES (?, ?)')->execute([$hashtag_id, $_POST['field_id']]);
        header('Location: fields.php?selected=' . $_POST['field_id']);
        exit;
    }
    if ($_POST['action'] === 'attach_hashtag') {
        $exists = $pdo->prepare('SELECT 1 FROM Field_Hashtag WHERE id_hashtag = ? AND id_field = ?');
        $exists->execute([$_POST['hashtag_id'], $_POST['field_id']]);
        if (!$exists->fetch()) {
            $pdo->prepare('INSERT INTO Field_Hashtag (id_hashtag, id_field) VALUES (?, ?)')->execute([$_POST['hashtag_id'], $_POST['field_id']]);
        }
        header('Location: fields.php?selected=' . $_POST['field_id']);
        exit;
    }
    if ($_POST['action'] === 'detach_hashtag') {
        $pdo->prepare('DELETE FROM Field_Hashtag WHERE id_hashtag = ? AND id_field = ?')->execute([$_POST['hashtag_id'], $_POST['field_id']]);
        header('Location: fields.php?selected=' . $_POST['field_id']);
        exit;
    }
}

$fields = $pdo->query('SELECT f.*, COUNT(fh.id_hashtag) as hashtag_count FROM Field f LEFT JOIN Field_Hashtag fh ON f.id = fh.id_field GROUP BY f.id ORDER BY f.id')->fetchAll(PDO::FETCH_ASSOC);

$selected_id = $_GET['selected'] ?? ($fields[0]['id'] ?? null);
$selected = null;
$attached_hashtags = [];
$all_hashtags = [];

if ($selected_id) {
    $stmt = $pdo->prepare('SELECT * FROM Field WHERE id = ?');
    $stmt->execute([$selected_id]);
    $selected = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT h.* FROM Hashtag h JOIN Field_Hashtag fh ON h.id = fh.id_hashtag WHERE fh.id_field = ?');
    $stmt->execute([$selected_id]);
    $attached_hashtags = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $attached_ids = array_column($attached_hashtags, 'id');
    $all_hashtags = $pdo->query('SELECT * FROM Hashtag')->fetchAll(PDO::FETCH_ASSOC);
    $all_hashtags = array_filter($all_hashtags, fn($h) => !in_array($h['id'], $attached_ids));
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>#сортер — области знаний</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: monospace;
    font-size: 14px;
    background: #f5f5f5;
    color: #222;
}

header {
    background: #fff;
    border-bottom: 1px solid #ddd;
    padding: 14px 24px;
    display: flex;
    align-items: center;
    gap: 24px;
}

.logo { font-weight: bold; font-size: 16px; }

nav { margin-left: auto; display: flex; gap: 4px; }
nav a {
    padding: 6px 12px;
    text-decoration: none;
    color: #555;
    border: 1px solid transparent;
    border-radius: 4px;
}
nav a:hover { background: #f0f0f0; }
nav a.active { border-color: #ddd; background: #f0f0f0; color: #222; }

.layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    min-height: calc(100vh - 49px);
}

.left {
    background: #fff;
    border-right: 1px solid #ddd;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.label {
    font-size: 11px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 10px;
}

.field-list { display: flex; flex-direction: column; gap: 2px; }

.field-row { display: flex; align-items: center; gap: 4px; }

.field-link {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 10px;
    text-decoration: none;
    color: #333;
    border-radius: 4px;
    border: 1px solid transparent;
}
.field-link:hover { background: #f5f5f5; }
.field-link.active { background: #f0f0f0; border-color: #ddd; }

.count {
    font-size: 11px;
    color: #999;
    background: #f0f0f0;
    padding: 2px 7px;
    border-radius: 10px;
}

.btn-del {
    background: none;
    border: none;
    color: #bbb;
    cursor: pointer;
    font-size: 16px;
    padding: 4px 6px;
    border-radius: 4px;
    line-height: 1;
}
.btn-del:hover { color: #c00; background: #fff0f0; }

.add-form { display: flex; flex-direction: column; gap: 8px; }

input[type=text], textarea, select {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: monospace;
    font-size: 13px;
    background: #fafafa;
    color: #222;
    outline: none;
}
input[type=text]:focus, textarea:focus, select:focus { border-color: #aaa; background: #fff; }

.btn {
    padding: 8px 14px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #fff;
    font-family: monospace;
    font-size: 13px;
    cursor: pointer;
    color: #333;
    transition: background 0.1s;
}
.btn:hover { background: #f0f0f0; }
.btn-dark {
    background: #222;
    color: #fff;
    border-color: #222;
}
.btn-dark:hover { background: #444; }

.right { padding: 32px 36px; }

.field-title { font-size: 22px; font-weight: bold; margin-bottom: 4px; }
.field-desc { color: #888; margin-bottom: 12px; font-size: 13px; }
.field-meta { color: #aaa; font-size: 12px; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid #e8e8e8; }

.section { margin-bottom: 28px; }

.tags-wrap { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }

.tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 4px;
    font-size: 13px;
    font-family: monospace;
}

.tag-on {
    background: #222;
    color: #fff;
}

.tag-off {
    background: #fff;
    border: 1px solid #ddd;
    color: #555;
    cursor: pointer;
}
.tag-off:hover { border-color: #aaa; color: #222; }

.tag-detach {
    background: none;
    border: none;
    color: #888;
    cursor: pointer;
    font-size: 14px;
    padding: 0;
    line-height: 1;
}
.tag-detach:hover { color: #c00; }

.new-tag-row {
    display: flex;
    gap: 8px;
    margin-top: 16px;
    padding-top: 20px;
    border-top: 1px solid #e8e8e8;
}

.muted { color: #aaa; font-size: 13px; }
</style>
</head>
<body>

<header>
    <span class="logo">#сортер</span>
    <nav>
        <a href="index.php">Сообщения</a>
        <a href="fields.php" class="active">Области знаний</a>
    </nav>
</header>

<div class="layout">
    <div class="left">
        <div>
            <div class="label">Области знаний</div>
            <div class="field-list">
                <?php foreach ($fields as $f): ?>
                <div class="field-row">
                    <a href="?selected=<?= $f['id'] ?>" class="field-link <?= $f['id'] == $selected_id ? 'active' : '' ?>">
                        <?= htmlspecialchars($f['name']) ?>
                        <span class="count"><?= $f['hashtag_count'] ?></span>
                    </a>
                    <form method="post">
                        <input type="hidden" name="action" value="delete_field">
                        <input type="hidden" name="field_id" value="<?= $f['id'] ?>">
                        <button class="btn-del" type="submit">×</button>
                    </form>
                </div>
                <?php endforeach; ?>
                <?php if (empty($fields)): ?>
                    <span class="muted">Пусто</span>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <div class="label">Добавить область</div>
            <form method="post" class="add-form">
                <input type="hidden" name="action" value="add_field">
                <input type="text" name="name" placeholder="Название" required>
                <input type="text" name="description" placeholder="Описание">
                <button class="btn btn-dark" type="submit">+ Добавить</button>
            </form>
        </div>
    </div>

    <div class="right">
        <?php if ($selected): ?>
            <div class="field-title"><?= htmlspecialchars($selected['name']) ?></div>
            <div class="field-desc"><?= htmlspecialchars($selected['description'] ?: '—') ?></div>
            <div class="field-meta">
                <?= count($attached_hashtags) ?> хэштег(ов) · создано <?= date('d.m.Y', strtotime($selected['data'])) ?>
            </div>

            <div class="section">
                <div class="label">Привязанные хэштеги</div>
                <div class="tags-wrap">
                    <?php foreach ($attached_hashtags as $h): ?>
                    <span class="tag tag-on">
                        #<?= htmlspecialchars($h['name']) ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="action" value="detach_hashtag">
                            <input type="hidden" name="hashtag_id" value="<?= $h['id'] ?>">
                            <input type="hidden" name="field_id" value="<?= $selected_id ?>">
                            <button class="tag-detach" type="submit">×</button>
                        </form>
                    </span>
                    <?php endforeach; ?>
                    <?php if (empty($attached_hashtags)): ?>
                        <span class="muted">Нет хэштегов</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="new-tag-row">
                <form method="post" style="display:flex;gap:8px;flex:1;">
                    <input type="hidden" name="action" value="add_hashtag">
                    <input type="hidden" name="field_id" value="<?= $selected_id ?>">
                    <input type="text" name="hashtag_name" placeholder="#новый_хэштег" required>
                    <button class="btn btn-dark" type="submit" style="white-space:nowrap;">Создать и привязать</button>
                </form>
            </div>

            <?php if (!empty($all_hashtags)): ?>
            <div class="section" style="margin-top:28px;">
                <div class="label">Все хэштеги — нажмите чтобы привязать</div>
                <div class="tags-wrap">
                    <?php foreach ($all_hashtags as $h): ?>
                    <form method="post">
                        <input type="hidden" name="action" value="attach_hashtag">
                        <input type="hidden" name="hashtag_id" value="<?= $h['id'] ?>">
                        <input type="hidden" name="field_id" value="<?= $selected_id ?>">
                        <button class="tag tag-off" type="submit">#<?= htmlspecialchars($h['name']) ?></button>
                    </form>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        <?php else: ?>
            <span class="muted">Выберите или создайте область знаний</span>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
