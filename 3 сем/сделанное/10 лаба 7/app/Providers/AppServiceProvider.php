<?php
// ЛР7. Gate::before: модератору возвращаю true — ему можно всё.

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // проверяется раньше всех остальных шлюзов и политик
        Gate::before(function (User $user) {
            if ($user->isModerator()) {
                return true;
            }
        });

        // менять и удалять комментарии может только модератор
        Gate::define('comment', function (User $user, Comment $comment) {
            return Response::deny('Изменять и удалять комментарии может только модератор.');
        });
    }
}
