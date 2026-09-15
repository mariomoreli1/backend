<?php

require __DIR__ . '/Db.php';
require __DIR__ . '/Article.php';
require __DIR__ . '/User.php';
require __DIR__ . '/Contact.php';
require __DIR__ . '/MainController.php';
require __DIR__ . '/ArticlesController.php';
require __DIR__ . '/CalcController.php';
require __DIR__ . '/ContactsController.php';

$routes = require __DIR__ . '/routes.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');
// убираем query string из uri
$uri = strtok($uri, '?');

foreach ($routes as $pattern => $handler) {
    if (preg_match($pattern, $uri, $matches)) {
        [$controllerClass, $method] = $handler;
        $controller = new $controllerClass();
        $params = array_slice($matches, 1);
        call_user_func_array([$controller, $method], $params);
        exit;
    }
}

echo '404 — страница не найдена';
