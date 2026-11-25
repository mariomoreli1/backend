<?php
// ЛР14. Посредник (make:middleware StatMiddleware): сохраняет url запроса и пользователя в таблицу paths.

namespace App\Http\Middleware;

use App\Models\Path;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // сохраняем url каждого просмотра статьи
        Path::create([
            'url' => $request->path(),
            'user_id' => auth()->id(),
        ]);

        return $next($request);
    }
}
