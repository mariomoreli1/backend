<?php
// ЛР7. create, update, delete — Response::deny со своим текстом.
// В шаблонах кнопки обёрнуты в @can.

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    // модератору всё разрешено через Gate::before в AppServiceProvider,
    // поэтому тут остаётся только отказ для остальных

    public function create(User $user)
    {
        return Response::deny('Добавлять новости может только модератор.');
    }

    public function update(User $user, Article $article)
    {
        return Response::deny('Редактировать новости может только модератор.');
    }

    public function delete(User $user, Article $article)
    {
        return Response::deny('Удалять новости может только модератор.');
    }
}
