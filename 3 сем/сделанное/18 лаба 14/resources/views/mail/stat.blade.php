{{-- ЛР14. Шаблон письма статистики: просмотры (всего и по статьям) и новые комментарии. --}}
<h2>Статистика сайта за {{ date('d.m.Y') }}</h2>

<p>Просмотров статей: {{ $views }}</p>
<p>Новых комментариев: {{ $comments }}</p>

@if (count($articles) > 0)
    <p>Что смотрели:</p>
    <ul>
        @foreach ($articles as $article)
            <li>{{ $article->url }} - {{ $article->count }} раз</li>
        @endforeach
    </ul>
@endif
