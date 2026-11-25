@extends('layout')

@section('title', 'Доступ запрещён')

@section('content')
    <h1>Доступ запрещён</h1>
    <p>{{ $exception->getMessage() ?: 'У вас нет прав на это действие.' }}</p>
    <p><a href="/">На главную</a></p>
@endsection
