<?php

namespace App\Jobs;

use App\Mail\ArticleMail;
use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class VeryLongJob implements ShouldQueue
{
    use Queueable;

    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): void
    {
        // отправка письма модераторам теперь идёт через очередь
        $moderators = User::whereHas('role', function ($query) {
            $query->where('name', 'moderator');
        })->get();

        Mail::to($moderators)->send(new ArticleMail($this->article));
    }
}
