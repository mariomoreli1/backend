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
        $articles = $this->db->query('SELECT * FROM `articles`;', [], 'Article');
        require __DIR__ . '/main.php';
    }
}