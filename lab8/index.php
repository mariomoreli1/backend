<?php

require_once 'MainController.php';

$controller = new MainController();

$uri = $_SERVER['REQUEST_URI'];

if (preg_match('#^/hello/(.+)$#', $uri, $matches)) {

    $controller->sayHello(urldecode($matches[1]));

} elseif (preg_match('#^/bye/(.+)$#', $uri, $matches)) {

    $controller->sayBye(urldecode($matches[1]));

} else {

    $controller->main();
}