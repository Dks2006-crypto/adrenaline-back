<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    // Получение списка тренеров для публичной страницы
    public function indexPublic()
    {
        $trainers = User::where('role_id', 3)
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
        if (!$trainer || $trainer->role_id !== 3) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        // Загружаем записи тренера, включая информацию о клиенте
        $bookings = $trainer->bookings()
            ->with(['user:id,name,phone,email']) // Клиент
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        /** @var \App\Models\User $trainer */
        $trainer = auth('jwt')->user();

        // Проверяем, что это тренер
        if (!$trainer || $trainer->role_id !== 3) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        // Проверяем, что бронирование принадлежит этому тренеру
        if ($booking->trainer_id !== $trainer->id) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        if ($request->status === 'cancelled') {
            $booking->update(['cancelled_at' => now()]);
        }

        return response()->json(['message' => 'Статус обновлен']);
    }
}
