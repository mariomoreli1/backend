<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header>
    <h2>Новости</h2>
    <nav>
        <a href="/">Главная</a>
        <a href="/article">Новости</a>
        <a href="/about">О нас</a>
        <a href="/contacts">Контакты</a>
        @guest
            <a href="/signin">Регистрация</a>
            <a href="/login">Вход</a>
        @endguest
        @auth
            <a href="/logout">Выход ({{ Auth::user()->name }})</a>
        @endauth
    </nav>
</header>

<div class="content">
    @yield('content')
</div>

<footer>
    Федоткин Арсений Андреевич, группа 251-321
</footer>

</body>
</html>
