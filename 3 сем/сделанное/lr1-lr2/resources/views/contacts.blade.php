@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
    <article class="text-page">
        <h1>Контакты</h1>

        <p>Данные приходят в шаблон массивом, который передан методом <code>view()</code>.</p>

        {{-- ЛР1: динамический вывод переданного массива --}}
        <dl class="contacts">
            @foreach ($contacts as $contact)
                <div class="contacts__row">
                    <dt>{{ $contact['type'] }}</dt>
                    <dd>
                        @if ($contact['link'])
                            <a href="{{ $contact['link'] }}">{{ $contact['value'] }}</a>
                        @else
                            {{ $contact['value'] }}
                        @endif
                    </dd>
                </div>
            @endforeach
        </dl>
    </article>
@endsection
