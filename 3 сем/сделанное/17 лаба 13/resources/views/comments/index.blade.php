@extends('layout')

@section('title', 'Модерация комментариев')

@section('content')
    <h1>Комментарии на модерации</h1>

    @if ($comments->count() == 0)
        <p>Новых комментариев нет.</p>
    @else
        <table>
            <tr>
                <th>Статья</th>
                <th>Автор</th>
                <th>Комментарий</th>
                <th>Дата</th>
                <th></th>
            </tr>
            @foreach ($comments as $comment)
                <tr>
                    <td><a href="/article/{{ $comment->article_id }}">{{ $comment->article->name }}</a></td>
                    <td>{{ $comment->user->name ?? 'Аноним' }}</td>
                    <td>{{ $comment->text }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>
                        <form action="/comment/{{ $comment->id }}/accept" method="POST">
                            @csrf
                            <button type="submit">Принять</button>
                        </form>
                        <form action="/comment/{{ $comment->id }}/reject" method="POST">
                            @csrf
                            <button type="submit">Отклонить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
