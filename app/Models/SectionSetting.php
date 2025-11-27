<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SectionSetting extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_link',
        'image',
        'extra_data',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'extra_data' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Получить URL изображения
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return asset('storage/' . $this->image);
    }

    /**
     * Найти секцию по ключу
     */
    public static function findByKey(string $key): ?self
    {
        return static::where('section_key', $key)->first();
    }

    /**
     * Получить активную секцию по ключу
     */
    public static function getActiveByKey(string $key): ?self
    {
        return static::where('section_key', $key)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Получить все активные секции
     */
    public static function getAllActive()
    {
        return static::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
