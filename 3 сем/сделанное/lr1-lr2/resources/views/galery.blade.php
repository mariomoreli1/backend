@extends('layouts.app')

@section('title', $item['title'])

@section('content')
    <article class="galery">
        <a class="back" href="{{ route('main') }}">&larr; Ко всем новостям</a>

        <h1>{{ $item['title'] }}</h1>
        <p class="galery__date">{{ date('d.m.Y', strtotime($item['date'])) }}</p>

        {{-- ЛР2: на странице galery показываем full_image --}}
        <img class="galery__image"
             src="{{ asset($item['full_image']) }}"
             alt="{{ $item['title'] }}">

        <p class="galery__text">{{ $item['announce'] }}</p>
    </article>
@endsection
