<?php

class MainController
{
    public function main()
    {
        $content = 'Главная страница';

        require 'main.php';
    }

    public function sayHello(string $name)
    {
        $title = 'Страница приветствия';

        $content = 'Привет, ' . $name;

        require 'main.php';
    }

    public function sayBye(string $name)
    {
        $title = 'Страница гудбай';
        $content = 'Пока, ' . $name;

        require 'main.php';
    }
}