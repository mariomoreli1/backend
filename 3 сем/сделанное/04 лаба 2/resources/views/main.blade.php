{{-- ЛР2. Главная: таблица новостей (дата, название, картинка, описание). preview_image — ссылка на /galery/{full_image}. --}}
@extends('layout')

@section('title', 'Главная')

@section('content')
    <h1>Добро пожаловать!</h1>
    <p>Это мой сайт на Laravel. Ниже новости из json файла.</p>

    <table>
        <tr>
            <th>Дата</th>
            <th>Название</th>
            <th>Картинка</th>
            <th>Описание</th>
        </tr>
        @foreach ($articles as $article)
            <tr>
                <td>{{ $article['date'] }}</td>
                <td>{{ $article['name'] }}</td>
                <td>
                    <a href="/galery/{{ $article['full_image'] }}">
                        <img src="/{{ $article['preview_image'] }}" width="150">
                    </a>
                </td>
                <td>{{ $article['shortDesc'] ?? '' }}</td>
            </tr>
        @endforeach
    </table>
@endsection
