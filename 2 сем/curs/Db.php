<?php

class Db
{
    private $pdo;

    public function __construct()
    {
        $dbOptions = (require __DIR__ . '/settings.php')['db'];
        $this->pdo = new PDO(
            'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');

        // Создаём таблицу контактов если её нет
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS `contacts` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `message` TEXT NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public function execute(string $sql, array $params = []): bool
    {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute($params);
    }
}
