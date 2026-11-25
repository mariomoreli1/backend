<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
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
        $comment->save();

        return redirect('/article/' . $request->article_id);
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

        return redirect('/article/' . $comment->article_id);
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('comment', $comment);

        $article_id = $comment->article_id;
        $comment->delete();

        return redirect('/article/' . $article_id);
    }
}
