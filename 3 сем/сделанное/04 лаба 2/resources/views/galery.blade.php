{{-- ЛР2. Страница галереи: выводит full_image выбранной новости. --}}
@extends('layout')

@section('title', 'Галерея')

@section('content')
    <a href="/">Назад</a>
    <br><br>
    <img src="/{{ $full_image }}" style="max-width: 100%">
@endsection
