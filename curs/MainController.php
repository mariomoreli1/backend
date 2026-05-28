<?php

class MainController
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function main()
    {
        $articles = $this->db->query('SELECT * FROM `articles` ORDER BY id DESC;', [], 'Article');

        // Динамическое приветствие по времени (лаб 1)
        $hour = (int)date('H');
        if ($hour >= 5-3 && $hour < 12-3) {
            $greeting = 'Доброе утро';
        } elseif ($hour >= 12-3 && $hour < 18-3) {
            $greeting = 'Добрый день';
        } elseif ($hour >= 18-3 && $hour < 22-3) {
            $greeting = 'Добрый вечер';
        } else {
            $greeting = 'Доброй ночи';
        }

        $currentDate = date('d.m.Y');
        $currentTime = date('H:i');

        require __DIR__ . '/tpl_main.php';
    }
}
