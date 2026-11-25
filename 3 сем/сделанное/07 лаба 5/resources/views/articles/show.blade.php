@extends('layout')

@section('title', $article->name)

@section('content')
    <a href="/article">Назад к новостям</a>

    <h1>{{ $article->name }}</h1>
    <p><i>{{ $article->date }}</i></p>
    <p><b>{{ $article->short_desc }}</b></p>
    <p>{{ $article->desc }}</p>

    <a href="/article/{{ $article->id }}/edit">Редактировать</a>

    <form action="/article/{{ $article->id }}" method="POST" style="display: inline">
        @csrf
        @method('DELETE')
        <button type="submit">Удалить</button>
    </form>
@endsection
