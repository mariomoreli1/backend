<?php

class ArticlesController
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function show(int $articleId)
    {
        $result = $this->db->query(
            'SELECT * FROM `articles` WHERE id = :id;',
            [':id' => $articleId],
            'Article'
        );

        $article = $result[0];

        $authorResult = $this->db->query(
            'SELECT * FROM `users` WHERE id = :id;',
            [':id' => $article->getAuthorId()],
            'User'
        );

        $author = $authorResult[0];

        require __DIR__ . '/single.php';
    }
}