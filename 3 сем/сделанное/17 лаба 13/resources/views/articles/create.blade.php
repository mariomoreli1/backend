@extends('layout')

@section('title', 'Новая новость')

@section('content')
    <h1>Добавить новость</h1>

    @include('articles.errors')

    <form action="/article" method="POST">
        @csrf

        <p>
            Дата<br>
            <input type="date" name="date" value="{{ old('date') }}">
        </p>
        <p>
            Название<br>
            <input type="text" name="name" value="{{ old('name') }}">
        </p>
        <p>
            Краткое описание<br>
            <input type="text" name="short_desc" value="{{ old('short_desc') }}">
        </p>
        <p>
            Текст<br>
            <textarea name="desc" rows="8" cols="60">{{ old('desc') }}</textarea>
        </p>

        <button type="submit">Сохранить</button>
    </form>
@endsection
