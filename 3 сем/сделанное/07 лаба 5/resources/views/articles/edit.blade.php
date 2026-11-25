{{-- ЛР5. В форме @method('PUT'), в удалении @method('DELETE') — html-форма умеет только GET и POST. --}}
@extends('layout')

@section('title', 'Редактирование')

@section('content')
    <h1>Редактировать новость</h1>

    @include('articles.errors')

    <form action="/article/{{ $article->id }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            Дата<br>
            <input type="date" name="date" value="{{ old('date', $article->date) }}">
        </p>
        <p>
            Название<br>
            <input type="text" name="name" value="{{ old('name', $article->name) }}">
        </p>
        <p>
            Краткое описание<br>
            <input type="text" name="short_desc" value="{{ old('short_desc', $article->short_desc) }}">
        </p>
        <p>
            Текст<br>
            <textarea name="desc" rows="8" cols="60">{{ old('desc', $article->desc) }}</textarea>
        </p>

        <button type="submit">Сохранить</button>
    </form>
@endsection
