<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewArticleNotify extends Notification
{
    use Queueable;

    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'article_id' => $this->article->id,
            'article_name' => $this->article->name,
        ];
    }
}
