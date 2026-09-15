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

        if (empty($result)) {
            echo '404 — статья не найдена';
            return;
        }

        $article = $result[0];

        $authorResult = $this->db->query(
            'SELECT * FROM `users` WHERE id = :id;',
            [':id' => $article->getAuthorId()],
            'User'
        );

        $author = $authorResult[0] ?? null;

        require __DIR__ . '/tpl_article.php';
    }

    public function edit(int $articleId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $text = trim($_POST['text'] ?? '');

            $this->db->execute(
                'UPDATE `articles` SET name = :name, text = :text WHERE id = :id;',
                [':name' => $name, ':text' => $text, ':id' => $articleId]
            );

            header('Location: /articles/' . $articleId);
            exit;
        }

        $result = $this->db->query(
            'SELECT * FROM `articles` WHERE id = :id;',
            [':id' => $articleId],
            'Article'
        );

        $article = $result[0];

        require __DIR__ . '/tpl_edit.php';
    }
}
