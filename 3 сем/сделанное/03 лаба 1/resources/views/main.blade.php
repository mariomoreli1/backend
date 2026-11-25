{{-- ЛР1. Страница-приветствие, наследует макет через @extends('layout'). --}}
@extends('layout')

@section('title', 'Главная')

@section('content')
    <h1>Добро пожаловать!</h1>
    <p>Это мой сайт на Laravel. Скоро здесь будут новости.</p>
@endsection
