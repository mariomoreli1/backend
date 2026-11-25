@extends('layout')

@section('title', 'Регистрация')

@section('content')
    <h1>Регистрация</h1>

    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="/signin" method="POST">
        @csrf

        <p>
            Имя<br>
            <input type="text" name="name" value="{{ old('name') }}">
        </p>
        <p>
            Email<br>
            <input type="text" name="email" value="{{ old('email') }}">
        </p>
        <p>
            Пароль<br>
            <input type="password" name="password">
        </p>

        <button type="submit">Зарегистрироваться</button>
    </form>
@endsection
