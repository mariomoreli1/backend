{{-- ЛР9. В меню ссылка «Модерация комментариев» — через @can('moderate'), видна только модератору. --}}
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
        @can('create', App\Models\Article::class)
            <a href="/article/create">Создать новость</a>
        @endcan
        @can('moderate')
            <a href="/comment">Модерация комментариев</a>
        @endcan
        <a href="/about">О нас</a>
        <a href="/contacts">Контакты</a>
        @guest
            <a href="/signin">Регистрация</a>
            <a href="/login">Вход</a>
        @endguest
        @auth
            <a href="/logout">Выход ({{ Auth::user()->name }}, {{ Auth::user()->role->title }})</a>
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
