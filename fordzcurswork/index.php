<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_sms') {
        $user_id     = 1;
        $channel_id  = (int)$_POST['channel_id'];
        $description = trim($_POST['description']);
        $save        = isset($_POST['save']) ? 1 : 0;
        $data        = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('INSERT INTO SMS (user_id, channel_id, description, data, save) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$user_id, $channel_id, $description, $data, $save]);
        $sms_id = $pdo->lastInsertId();

        if (!empty($_POST['hashtags'])) {
            $stmtH = $pdo->prepare('INSERT INTO SMS_Hashtag (id_sms, id_hashtag) VALUES (?, ?)');
            foreach ($_POST['hashtags'] as $hashtag_id) {
                $stmtH->execute([$sms_id, (int)$hashtag_id]);
            }
        }

        header('Location: index.php?success=1');
        exit;
    }
}

$channels = $pdo->query('SELECT * FROM Channel')->fetchAll(PDO::FETCH_ASSOC);
$hashtags = $pdo->query('SELECT * FROM Hashtag ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);

$messages = $pdo->query('
    SELECT s.*, c.name as channel_name, GROUP_CONCAT(h.name SEPARATOR ",") as tags
    FROM SMS s
    LEFT JOIN Channel c ON s.channel_id = c.id
    LEFT JOIN SMS_Hashtag sh ON s.id = sh.id_sms
    LEFT JOIN Hashtag h ON sh.id_hashtag = h.id
    GROUP BY s.id
    ORDER BY s.data DESC
    LIMIT 10
')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>#сортер</title>
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
    grid-template-columns: 340px 1fr;
    min-height: calc(100vh - 49px);
}

.left {
    background: #fff;
    border-right: 1px solid #ddd;
    padding: 24px 20px;
}

.label {
    font-size: 11px;
    color: #2c2c2cff;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 12px;
}

.form { display: flex; flex-direction: column; gap: 10px; }

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
textarea { min-height: 110px; resize: vertical; }

.btn {
    padding: 9px 14px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #fff;
    font-family: monospace;
    font-size: 13px;
    cursor: pointer;
    color: #333;
}
.btn:hover { background: #f0f0f0; }
.btn-dark { background: #222; color: #fff; border-color: #222; width: 100%; }
.btn-dark:hover { background: #444; }

.tags-wrap { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 2px; }

.tag-checkbox { display: none; }
.tag-label {
    display: inline-block;
    padding: 4px 11px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 12px;
    font-family: monospace;
    color: #555;
    cursor: pointer;
    background: #fafafa;
}
.tag-label:hover { border-color: #aaa; color: #222; }
.tag-checkbox:checked + .tag-label {
    background: #222;
    color: #fff;
    border-color: #222;
}

.save-row {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #555;
    font-size: 13px;
    cursor: pointer;
}
.save-row input { width: auto; }

.success {
    padding: 10px 12px;
    background: #f0f0f0;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 13px;
    color: #555;
    margin-bottom: 14px;
}


.right { padding: 28px 32px; }

.msg-list { display: flex; flex-direction: column; gap: 10px; margin-top: 12px; }

.msg-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 14px 16px;
}
.msg-card:hover { border-color: #aaa; }

.msg-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.msg-channel { font-weight: bold; font-size: 12px; }
.msg-date { font-size: 11px; color: #aaa; margin-left: auto; }
.msg-private {
    font-size: 11px;
    color: #aaa;
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 1px 6px;
}

.msg-text { font-size: 13px; line-height: 1.6; margin-bottom: 10px; color: #333; }

.msg-tags { display: flex; flex-wrap: wrap; gap: 5px; }
.msg-tag {
    font-size: 11px;
    padding: 2px 8px;
    border: 1px solid #e0e0e0;
    border-radius: 3px;
    color: #2c2c2cff;
    font-family: monospace;
}

.muted { color: #aaa; font-size: 13px; }
</style>
</head>
<body>

<header>
    <span class="logo">#сортер</span>
    <nav>
        <a href="index.php" class="active">Сообщения</a>
        <a href="fields.php">Области знаний</a>
    </nav>
</header>

<div class="layout">
    <div class="left">
        <div class="label">Новое сообщение</div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">✓ Сообщение добавлено</div>
        <?php endif; ?>

        <form method="post" class="form">
            <input type="hidden" name="action" value="add_sms">

            <select name="channel_id" required>
                <option value="" disabled selected>Канал...</option>
                <?php foreach ($channels as $ch): ?>
                    <option value="<?= $ch['id'] ?>"><?= htmlspecialchars($ch['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <textarea name="description" placeholder="Текст сообщения..." required></textarea>

            <?php if (!empty($hashtags)): ?>
            <div>
                <div class="label" style="margin-bottom:8px;">Хэштеги</div>
                <div class="tags-wrap">
                    <?php foreach ($hashtags as $h): ?>
                        <input class="tag-checkbox" type="checkbox" name="hashtags[]" value="<?= $h['id'] ?>" id="tag_<?= $h['id'] ?>">
                        <label class="tag-label" for="tag_<?= $h['id'] ?>">#<?= htmlspecialchars($h['name']) ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <label class="save-row">
                <input type="checkbox" name="save">
                приватное
            </label>

            <button class="btn btn-dark" type="submit">Отправить</button>
        </form>
    </div>

    <div class="right">
        <div class="label">Последние сообщения</div>
        <div class="msg-list">
            <?php if (empty($messages)): ?>
                <span class="muted">Нет сообщений</span>
            <?php endif; ?>
            <?php foreach ($messages as $m): ?>
            <div class="msg-card">
                <div class="msg-header">
                    <span class="msg-channel"><?= htmlspecialchars($m['channel_name'] ?? '—') ?></span>
                    <?php if ($m['save']): ?>
                        <span class="msg-private">приватное</span>
                    <?php endif; ?>
                    <span class="msg-date"><?= $m['data'] ?></span>
                </div>
                <div class="msg-text"><?= htmlspecialchars($m['description']) ?></div>
                <?php if ($m['tags']): ?>
                <div class="msg-tags">
                    <?php foreach (explode(',', $m['tags']) as $tag): ?>
                        <span class="msg-tag">#<?= htmlspecialchars(trim($tag)) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>
