<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('date', 'desc')->paginate(5);

        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
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

        return redirect('/article');
    }

    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    public function edit(Article $article)
    {
        return view('articles.edit', ['article' => $article]);
    }

    public function update(Request $request, Article $article)
    {
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
        // сначала удаляем комментарии этой статьи
        $article->comments()->delete();
        $article->delete();

        return redirect('/article');
    }
}
