<?php
# index берёт статьи из базы и отдаёт в шаблон, там таблица через foreach.
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('date', 'desc')->get();

        return view('articles.index', ['articles' => $articles]);
    }
}
