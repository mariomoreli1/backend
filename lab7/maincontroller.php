<?php

class MainController
{
    public function main()
    {
        echo '
            <h1>Главная страница</h1>

            <a href="/hello/Иван">
                <button>Сказать привет</button>
            </a>

            <br><br>

            <a href="/bye/Иван">
                <button>Сказать пока</button>
            </a>
        ';
    }

    public function sayHello(string $name)
    {
        echo '
            <h1>Привет, ' . htmlspecialchars($name) . '</h1>

            <a href="/">
                <button>Назад</button>
            </a>
        ';
    }

    public function sayBye(string $name)
    {
        echo '
            <h1>Пока, ' . htmlspecialchars($name) . '</h1>

            <a href="/">
                <button>Назад</button>
            </a>
        ';
    }
}