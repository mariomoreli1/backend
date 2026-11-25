{{-- ЛР12. В меню выпадающий список <details> «Уведомления (кол-во)» с непрочитанными; ссылка ведёт на /article/ID?notify=ID_уведомления. --}}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/style.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            <details class="notify">
                <summary>Уведомления ({{ auth()->user()->unreadNotifications->count() }})</summary>
                <div class="notify-list">
                    @forelse (auth()->user()->unreadNotifications as $notification)
                        <a href="/article/{{ $notification->data['article_id'] }}?notify={{ $notification->id }}">
                            Новая статья: {{ $notification->data['article_name'] }}
                        </a>
                    @empty
                        <span>Нет новых уведомлений</span>
                    @endforelse
                </div>
            </details>
            <a href="/logout">Выход ({{ Auth::user()->name }}, {{ Auth::user()->role->title }})</a>
        @endauth
    </nav>
</header>

<div class="content">
    <div id="app">

    </div>

    @yield('content')
</div>

<footer>
    Федоткин Арсений Андреевич, группа 251-321
</footer>

</body>
</html>
