<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    // Получение списка тренеров для публичной страницы
    public function indexPublic()
    {
        // Роль 'trainer' обычно имеет ID 2 (если следовать стандартной практике)
        $trainers = User::where('role_id', 2)
            ->select('id', 'name', 'last_name', 'avatar', 'bio', 'specialties', 'rating', 'reviews_count')
            ->get()
            ->makeHidden('avatar');

        return response()->json($trainers);
    }

    // Получение записей, привязанных к текущему авторизованному тренеру
    public function indexBookings()
    {
        /** @var \App\Models\User $trainer */
        $trainer = auth('jwt')->user();

        // Проверяем, что это тренер
        if (!$trainer || $trainer->role_id !== 2) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        // Загружаем записи тренера, включая информацию о клиенте
        $bookings = $trainer->bookings()
            ->with(['user:id,name,phone,email']) // Клиент
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($bookings);
    }
}
