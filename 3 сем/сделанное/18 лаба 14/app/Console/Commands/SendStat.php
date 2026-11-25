<?php
// ЛР14. Команда stat:send (make:command SendStat): считает просмотры статей и новые комментарии за сегодня и шлёт StatMail модераторам.

namespace App\Console\Commands;

use App\Mail\StatMail;
use App\Models\Comment;
use App\Models\Path;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendStat extends Command
{
    protected $signature = 'stat:send';

    protected $description = 'Отправить модераторам статистику за день';

    public function handle()
    {
        // сколько раз сегодня открывали статьи
        $views = Path::whereDate('created_at', today())->count();

        // сколько просмотров у каждой статьи
        $articles = Path::whereDate('created_at', today())
            ->selectRaw('url, count(*) as count')
            ->groupBy('url')
            ->orderByDesc('count')
            ->get();

        // сколько комментариев добавили сегодня
        $comments = Comment::whereDate('created_at', today())->count();

        $moderators = User::whereHas('role', function ($query) {
            $query->where('name', 'moderator');
        })->get();

        Mail::to($moderators)->send(new StatMail($views, $comments, $articles));

        $this->info("Отправлено: просмотров $views, комментариев $comments");
    }
}
