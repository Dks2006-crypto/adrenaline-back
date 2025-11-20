<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            // Одно из полей должно присутствовать, но не оба
            'form_id'    => 'nullable|exists:forms,id',
            'trainer_id' => 'nullable|exists:users,id',
            'note'       => 'nullable|string',
        ]);

        // 🚨 КРИТИЧЕСКАЯ ПРОВЕРКА: Либо form_id, либо trainer_id
        if (!$request->form_id && !$request->trainer_id) {
            return response()->json(['error' => 'Необходимо указать занятие или тренера'], 400);
        }
        if ($request->form_id && $request->trainer_id) {
            return response()->json(['error' => 'Нельзя одновременно бронировать занятие и тренера'], 400);
        }

        $user = auth('jwt')->user();
        $class_id = null; // Для групповых
        $trainer_id = $request->trainer_id; // Для персональных

        // 1. Если это ГРУППОВОЕ ЗАНЯТИЕ
        if ($request->form_id) {
            $form = Form::findOrFail($request->form_id);
            $class_id = $form->id;
            $trainer_id = $form->trainer_id; // Берем тренера из формы, если есть

            // Проверка мест
            if ($form->availableSlots() <= 0) {
                return response()->json(['error' => 'Нет мест'], 400);
            }
        }

        // 2. Если это ПЕРСОНАЛЬНАЯ ТРЕНИРОВКА
        if ($request->trainer_id) {
            // Здесь может быть дополнительная логика проверки расписания тренера,
            // но пока просто проверяем, что trainer_id принадлежит тренеру (role_id = 2)
            $trainer = User::where('id', $request->trainer_id)->where('role_id', 2)->first();
            if (!$trainer) {
                return response()->json(['error' => 'Тренер не найден'], 404);
            }
        }

        // 3. ПРОВЕРКА ПОДПИСКИ (ОДИНАКОВА ДЛЯ ОБОИХ ТИПОВ)
        $membership = $user->memberships()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->first();

        if (!$membership || ($membership->remaining_visits !== null && $membership->remaining_visits <= 0)) {
            return response()->json(['error' => 'Нет активной подписки или посещений'], 400);
        }

        // 4. СОЗДАНИЕ ЗАПИСИ
        $booking = Booking::create([
            'user_id' => $user->id,
            'class_id' => $class_id,       // null для персональной, ID формы для групповой
            'trainer_id' => $trainer_id,   // ID тренера
            'status' => 'pending',         // Персональные могут требовать подтверждения
            'note' => $request->note,
        ]);

        // 5. СПИСАНИЕ ПОСЕЩЕНИЯ
        if ($membership->remaining_visits !== null) {
            $membership->decrement('remaining_visits');
        }

        return response()->json([
            'message' => 'Запись отправлена. Ожидайте подтверждения.',
            'booking' => $booking->load('form.service', 'trainer'),
        ]);
    }

    public function storeTrainer(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:users,id',
            'note' => 'nullable|string|max:500',
        ]);

        $user = auth('jwt')->user();
        $trainer = User::findOrFail($request->trainer_id);

        // В реальном приложении здесь может быть проверка на персональные визиты в абонементе.
        // Для MVP: создаем запись со статусом "ожидание".

        $booking = Booking::create([
            'user_id' => $user->id,
            'trainer_id' => $trainer->id,
            'class_id' => null, // Отмечаем как не-групповое занятие
            'status' => 'pending', // Тренер должен подтвердить
            'note' => $request->note ?? 'Запрос на персональную тренировку',
        ]);

        return response()->json([
            'message' => 'Запрос на личную тренировку отправлен тренеру ' . $trainer->name . '. Он свяжется с вами в течение часа.',
            'booking' => $booking,
        ], 201);
    }

    public function index()
    {
        return auth('jwt')->user()
            ->bookings()
            ->latest()
            ->with([
                // Для групповых занятий:
                'form.service',
                'form.trainer',
                // Для личных тренировок:
                'trainer',
            ])
            ->get();
    }
}
