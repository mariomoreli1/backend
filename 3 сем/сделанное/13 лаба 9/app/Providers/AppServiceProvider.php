<?php
// ЛР9. Шлюз moderate — доступ только модератору (его пропускает Gate::before, остальным отказ). Нужен для страницы модерации и меню.

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

        // менять и удалять комментарий может только его автор (и модератор через before)
        Gate::define('comment', function (User $user, Comment $comment) {
            if ($user->id == $comment->user_id) {
                return Response::allow();
            }

            return Response::deny('Изменять и удалять комментарий может только его автор.');
        });

        // модерация комментариев только для модератора
        Gate::define('moderate', function (User $user) {
            return Response::deny('Модерировать комментарии может только модератор.');
        });
    }
}
