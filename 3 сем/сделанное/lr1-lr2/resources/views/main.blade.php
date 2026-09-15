@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    {{-- ЛР1: приветственное сообщение --}}
    <section class="hero">
        <h1>Добро пожаловать!</h1>
        <p>
            Это учебный сайт, собранный на Laravel в рамках лабораторных работ №1 и №2.
            Ниже -- лента новостей, которая подгружается из файла
            <code>public/data/news.json</code> методом <code>index</code> контроллера
            <code>MainController</code>.
        </p>
    </section>

    {{-- ЛР2: вывод данных из json-файла --}}
    <section class="news">
        <h2>Новости</h2>

        @if (count($news) === 0)
            <p class="empty">Новостей пока нет.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Превью</th>
                    <th>Заголовок</th>
                    <th>Дата</th>
                    <th>Анонс</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($news as $item)
                    <tr>
                        <td class="table__preview">
                            {{-- preview_image -- ссылка на страницу galery --}}
                            <a href="{{ route('galery', $item['id']) }}">
                                <img src="{{ asset($item['preview_image']) }}"
                                     alt="{{ $item['title'] }}">
                            </a>
                        </td>
                        <td>
                            <a class="table__title" href="{{ route('galery', $item['id']) }}">
                                {{ $item['title'] }}
                            </a>
                        </td>
                        <td class="table__date">
                            {{ date('d.m.Y', strtotime($item['date'])) }}
                        </td>
                        <td>{{ $item['announce'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection
