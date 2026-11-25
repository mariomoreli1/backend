@extends('layout')
# index берёт статьи из базы и отдаёт в шаблон, там таблица через foreach.
@section('title', 'Новости')

@section('content')
    <h1>Новости</h1>

    <table>
        <tr>
            <th>Дата</th>
            <th>Название</th>
            <th>Описание</th>
        </tr>
        @foreach ($articles as $article)
            <tr>
                <td>{{ $article->date }}</td>
                <td>{{ $article->name }}</td>
                <td>{{ $article->short_desc }}</td>
            </tr>
        @endforeach
    </table>
@endsection
