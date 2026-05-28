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

    public function edit(int $articleId)
    {
        // Если форма отправлена — сохраняем
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $text = $_POST['text'];

            $this->db->query(
                'UPDATE `articles` SET name = :name, text = :text WHERE id = :id;',
                [':name' => $name, ':text' => $text, ':id' => $articleId]
            );

            header('Location: /articles/' . $articleId);
            exit;
        }

        // Иначе показываем форму
        $result = $this->db->query(
            'SELECT * FROM `articles` WHERE id = :id;',
            [':id' => $articleId],
            'Article'
        );

        $article = $result[0];

        require __DIR__ . '/edit.php';
    }
}