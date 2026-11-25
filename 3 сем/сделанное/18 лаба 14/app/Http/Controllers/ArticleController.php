<?php

namespace App\Http\Controllers;

use App\Events\NewArticleEvent;
use App\Jobs\VeryLongJob;
use App\Models\Article;
use App\Models\User;
use App\Notifications\NewArticleNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class ArticleController extends Controller
{
    public function index()
    {
        // кэшируем каждую страницу пагинации отдельно
        $page = request('page', 1);
        $articles = Cache::remember('articles_page_' . $page, 3000, function () {
            return Article::orderBy('date', 'desc')->paginate(5);
        });

        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        Gate::authorize('create', Article::class);

        return view('articles.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Article::class);

        $request->validate([
            'date' => 'required|date',
            'name' => 'required|min:3|max:100',
            'short_desc' => 'max:255',
            'desc' => 'required|min:10',
        ]);

        $article = new Article();
        $article->date = $request->date;
        $article->name = $request->name;
        $article->short_desc = $request->short_desc;
        $article->desc = $request->desc;
        $article->save();

        // чистим кэш списка новостей на всех страницах
        $pages = ceil(Article::count() / 5);
        for ($i = 1; $i <= $pages; $i++) {
            Cache::forget('articles_page_' . $i);
        }

        // письмо модераторам отправляем через очередь
        VeryLongJob::dispatch($article);

        // пуш-уведомление всем, кто сейчас на сайте
        NewArticleEvent::dispatch($article);

        // уведомление читателям (всем кроме того, кто сейчас залогинен)
        $readers = User::where('id', '!=', auth()->id())
            ->whereHas('role', function ($query) {
                $query->where('name', 'reader');
            })->get();
        Notification::send($readers, new NewArticleNotify($article));

        return redirect('/article');
    }

    public function show(Request $request, Article $article)
    {
        // если перешли из уведомления, отмечаем его прочитанным
        if ($request->notify && auth()->check()) {
            $notification = auth()->user()->notifications()->where('id', $request->notify)->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }

        // показываем только комментарии, которые прошли модерацию, и кэшируем их
        $comments = Cache::rememberForever('article_' . $article->id, function () use ($article) {
            return $article->comments()->where('accept', true)->get();
        });

        return view('articles.show', ['article' => $article, 'comments' => $comments]);
    }

    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        return view('articles.edit', ['article' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

        $request->validate([
            'date' => 'required|date',
            'name' => 'required|min:3|max:100',
            'short_desc' => 'max:255',
            'desc' => 'required|min:10',
        ]);

        $article->date = $request->date;
        $article->name = $request->name;
        $article->short_desc = $request->short_desc;
        $article->desc = $request->desc;
        $article->save();

        Cache::flush();

        return redirect('/article/' . $article->id);
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        // сначала удаляем комментарии этой статьи
        $article->comments()->delete();
        $article->delete();

        Cache::flush();

        return redirect('/article');
    }
}
