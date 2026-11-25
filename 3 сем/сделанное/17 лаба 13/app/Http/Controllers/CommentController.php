<?php
// ЛР13. После принятия, изменения и удаления комментария — Cache::forget('article_' . id), чтобы на странице не висели старые комментарии.

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    // список комментариев, которые ждут модерации
    public function index()
    {
        Gate::authorize('moderate');

        $comments = Comment::where('accept', false)->orderBy('created_at')->get();

        return view('comments.index', ['comments' => $comments]);
    }

    public function accept(Comment $comment)
    {
        Gate::authorize('moderate');

        $comment->accept = true;
        $comment->save();

        // чтобы комментарий появился на странице статьи
        Cache::forget('article_' . $comment->article_id);

        return redirect('/comment');
    }

    public function reject(Comment $comment)
    {
        Gate::authorize('moderate');

        $comment->delete();
        Cache::forget('article_' . $comment->article_id);

        return redirect('/comment');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|min:3|max:1000',
            'article_id' => 'required|exists:articles,id',
        ]);

        $comment = new Comment();
        $comment->text = $request->text;
        $comment->article_id = $request->article_id;
        $comment->user_id = auth()->id();
        $comment->accept = false;
        $comment->save();

        return redirect('/article/' . $request->article_id)
            ->with('message', 'Комментарий отправлен и ожидает модерации.');
    }

    public function edit(Comment $comment)
    {
        Gate::authorize('comment', $comment);

        return view('comments.edit', ['comment' => $comment]);
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('comment', $comment);

        $request->validate([
            'text' => 'required|min:3|max:1000',
        ]);

        $comment->text = $request->text;
        $comment->save();
        Cache::forget('article_' . $comment->article_id);

        return redirect('/article/' . $comment->article_id);
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('comment', $comment);

        $article_id = $comment->article_id;
        $comment->delete();
        Cache::forget('article_' . $article_id);

        return redirect('/article/' . $article_id);
    }
}
