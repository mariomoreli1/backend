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

    <hr>

    <h3>Комментарии</h3>

    @foreach ($article->comments as $comment)
        <div class="comment">
            <p>{{ $comment->text }}</p>
            <small>{{ $comment->created_at }}</small>

            <a href="/comment/{{ $comment->id }}/edit">изменить</a>
            <form action="/comment/{{ $comment->id }}" method="POST" style="display: inline">
                @csrf
                @method('DELETE')
                <button type="submit">удалить</button>
            </form>
        </div>
    @endforeach

    @if ($article->comments->count() == 0)
        <p>Комментариев пока нет.</p>
    @endif

    <h3>Добавить комментарий</h3>

    @include('articles.errors')

    <form action="/comment" method="POST">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <textarea name="text" rows="4" cols="60">{{ old('text') }}</textarea>
        <br>
        <button type="submit">Отправить</button>
    </form>
@endsection
