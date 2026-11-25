<?php
// ЛР9. show: на странице статьи только одобренные комментарии — where('accept', true).

namespace App\Http\Controllers;

use App\Mail\ArticleMail;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('date', 'desc')->paginate(5);

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

        // письмо модераторам о новой статье
        $moderators = User::whereHas('role', function ($query) {
            $query->where('name', 'moderator');
        })->get();
        Mail::to($moderators)->send(new ArticleMail($article));

        return redirect('/article');
    }

    public function show(Article $article)
    {
        // показываем только комментарии, которые прошли модерацию
        $comments = $article->comments()->where('accept', true)->get();

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

        return redirect('/article/' . $article->id);
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        // сначала удаляем комментарии этой статьи
        $article->comments()->delete();
        $article->delete();

        return redirect('/article');
    }
}
