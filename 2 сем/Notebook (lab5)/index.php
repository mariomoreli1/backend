<?php
// Подключение к SQLite
$dbFile = __DIR__ . '/contacts.db';
$pdo = new PDO("sqlite:$dbFile");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    surname TEXT NOT NULL,
    name TEXT NOT NULL,
    lastname TEXT,
    gender TEXT,
    date TEXT,
    phone TEXT,
    location TEXT,
    email TEXT,
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

session_start();


$action = $_GET['action'] ?? 'view';

// Параметры для просмотра
$sort = $_GET['sort'] ?? 'default';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

require_once 'menu.php';
$menu_html = getMenu($action, $sort);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?= $menu_html ?>
    </header>

    <main>
        <?php
        switch ($action) {
            case 'add':
                require_once 'add.php';
                echo addContact($pdo);
                break;

            case 'edit':
                require_once 'edit.php';
                echo editContact($pdo);
                break;

            case 'delete':
                require_once 'delete.php';
                echo deleteContact($pdo);
                break;

            case 'view':
            default:
                require_once 'viewer.php';
                echo getViewer($pdo, $sort, $page);
                break;
        }
        ?>
    </main>

    <footer></footer>
</body>
</html>