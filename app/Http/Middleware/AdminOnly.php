<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        // ←←← ВОТ ГЛАВНОЕ ИЗМЕНЕНИЕ
        if (!Auth::user()->isAdmin()) {
            // Разлогиниваем обычного пользователя
            Auth::guard('web')->logout();

            // Опционально: можно сбросить сессию полностью
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Перенаправляем на логин с сообщением
            return redirect()
                ->route('filament.admin.auth.login')
                ->with('error', 'Доступ в админ-панель есть только у администраторов.');
        }

        return $next($request);
    }
}
