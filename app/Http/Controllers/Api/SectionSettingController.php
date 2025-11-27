<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SectionSetting;
use Illuminate\Http\JsonResponse;

class SectionSettingController extends Controller
{
    /**
     * Получить настройки Hero секции
     */
    public function index(): JsonResponse
    {
        $section = SectionSetting::getActiveByKey('hero');

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Hero секция не найдена',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatSection($section),
        ]);
    }

    /**
     * Получить секцию по ключу (только hero)
     */
    public function show(string $key): JsonResponse
    {
        if ($key !== 'hero') {
            return response()->json([
                'success' => false,
                'message' => 'Доступна только hero секция',
            ], 404);
        }

        $section = SectionSetting::getActiveByKey($key);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Hero секция не найдена',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatSection($section),
        ]);
    }

    /**
     * Форматировать данные секции для ответа API
     */
    private function formatSection(SectionSetting $section): array
    {
        return [
            'section_key' => $section->section_key,
            'title' => $section->title,
            'subtitle' => $section->subtitle,
            'description' => $section->description,
            'button_text' => $section->button_text,
            'button_link' => $section->button_link,
            'image_url' => $section->image_url,
            'extra_data' => $section->extra_data,
            'sort_order' => $section->sort_order,
        ];
    }
}
