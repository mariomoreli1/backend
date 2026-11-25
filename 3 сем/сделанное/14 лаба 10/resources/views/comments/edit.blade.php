@extends('layout')

@section('title', 'Изменить комментарий')

@section('content')
    <h1>Изменить комментарий</h1>

    @include('articles.errors')

    <form action="/comment/{{ $comment->id }}" method="POST">
        @csrf
        @method('PUT')
        <textarea name="text" rows="4" cols="60">{{ old('text', $comment->text) }}</textarea>
        <br>
        <button type="submit">Сохранить</button>
    </form>

    <p><a href="/article/{{ $comment->article_id }}">Назад к статье</a></p>
@endsection
