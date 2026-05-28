<?php

class ContactsController
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function index()
    {
        $success = false;
        $errors  = [];
        $form    = ['name' => '', 'email' => '', 'message' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $form['name']    = trim($_POST['name'] ?? '');
            $form['email']   = trim($_POST['email'] ?? '');
            $form['message'] = trim($_POST['message'] ?? '');

            if (empty($form['name']))    $errors[] = 'Введите имя';
            if (empty($form['email']))   $errors[] = 'Введите email';
            if (empty($form['message'])) $errors[] = 'Введите сообщение';

            if (empty($errors)) {
                $this->db->execute(
                    'INSERT INTO `contacts` (name, email, message) VALUES (:name, :email, :message);',
                    [':name' => $form['name'], ':email' => $form['email'], ':message' => $form['message']]
                );
                $success = true;
                $form    = ['name' => '', 'email' => '', 'message' => ''];
            }
        }

        $contacts = $this->db->query(
            'SELECT * FROM `contacts` ORDER BY created_at DESC LIMIT 20;',
            [],
            'Contact'
        );

        require __DIR__ . '/tpl_contacts.php';
    }
}
