<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Сайт факультета')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

{{-- ЛР1: шапка с навигацией --}}
<header class="header">
    <div class="container header__inner">
        <a class="logo" href="{{ route('main') }}">Мосполитех<span>.новости</span></a>

        <nav class="nav">
            <a class="nav__link {{ request()->routeIs('main') ? 'is-active' : '' }}"
               href="{{ route('main') }}">Главная</a>
            <a class="nav__link {{ request()->routeIs('about') ? 'is-active' : '' }}"
               href="{{ route('about') }}">О нас</a>
            <a class="nav__link {{ request()->routeIs('contacts') ? 'is-active' : '' }}"
               href="{{ route('contacts') }}">Контакты</a>
        </nav>
    </div>
</header>

{{-- Основная часть: сюда подставляется содержимое конкретной страницы --}}
<main class="main">
    <div class="container">
        @yield('content')
    </div>
</main>

{{-- ЛР1: подвал с ФИО и группой --}}
<footer class="footer">
    <div class="container">
        <p>Федоткин Арсений Андреевич, группа 251-321</p>
        <p class="footer__muted">Лабораторные работы №1-2, «Серверная разработка», {{ date('Y') }}</p>
    </div>
</footer>

</body>
</html>
