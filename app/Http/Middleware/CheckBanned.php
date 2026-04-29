<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_banned) {
            auth()->logout();

            return redirect()->route('posts.index')
                ->with('success', 'Ваш аккаунт заблокирован. Доступен только просмотр.');
        }

        return $next($request);
    }
}
