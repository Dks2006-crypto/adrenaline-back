<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    /**
     * Возвращает абонементы текущего авторизованного пользователя.
     */
    public function index()
    {
        $user = auth('jwt')->user();

        // 🚨 КРИТИЧЕСКОЕ ИСПРАВЛЕНИЕ:
        // 1. Фильтруем по текущему пользователю.
        // 2. Обязательно загружаем связь 'service' (метод with('service')),
        //    которая необходима фронтенду для отображения названия.
        $memberships = $user->memberships()
            ->with('service')
            ->orderBy('end_date', 'desc')
            ->get();

        return response()->json($memberships);
    }
}
