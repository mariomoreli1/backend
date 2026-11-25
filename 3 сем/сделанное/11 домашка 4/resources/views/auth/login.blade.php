@extends('layout')

@section('title', 'Вход')

@section('content')
    <h1>Вход</h1>

    @include('articles.errors')

    <form action="/login" method="POST">
        @csrf

        <p>
            Email<br>
            <input type="text" name="email" value="{{ old('email') }}">
        </p>
        <p>
            Пароль<br>
            <input type="password" name="password">
        </p>

        <button type="submit">Войти</button>
    </form>

    <p>Нет аккаунта? <a href="/signin">Зарегистрироваться</a></p>
@endsection
