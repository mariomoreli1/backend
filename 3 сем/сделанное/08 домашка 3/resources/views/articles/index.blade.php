@extends('layout')

@section('title', 'Новости')

@section('content')
    <h1>Новости</h1>

    <p><a href="/article/create">Добавить новость</a></p>

    <table>
        <tr>
            <th>Дата</th>
            <th>Название</th>
            <th>Описание</th>
        </tr>
        @foreach ($articles as $article)
            <tr>
                <td>{{ $article->date }}</td>
                <td><a href="/article/{{ $article->id }}">{{ $article->name }}</a></td>
                <td>{{ $article->short_desc }}</td>
            </tr>
        @endforeach
    </table>

    {{ $articles->links('pagination::bootstrap-4') }}
@endsection
