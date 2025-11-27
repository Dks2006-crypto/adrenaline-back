<?php

namespace Database\Seeders;

use App\Models\SectionSetting;
use Illuminate\Database\Seeder;

class SectionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'Почему выбирают именно нас? Потому что мы создали фитнес без отговорок.',
                'subtitle' => '',
                'description' => '• Команда, которая вдохновляет: Наши тренеры — не просто инструкторы, а ваши персональные мотиваторы. Они найдут подход к каждому и добьются результата вместе с вами.

• Атмосфера, в которую хочется возвращаться: Чистота, современное оборудование и дружелюбные сотрудники. Здесь вас поддержат и всегда рады видеть.

• Результат, который вы полюбите: Мы помогаем не просто похудеть или накачаться, а полюбить своё тело и ощутить радость от движения.',
                'button_text' => null,
                'button_link' => null,
                'image' => null, // Изображение будет загружено через админку
                'extra_data' => [
                    'background_overlay' => 'rgba(0,0,0,0.5)',
                    'text_color' => '#ffffff',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
        ];

        foreach ($sections as $section) {
            SectionSetting::updateOrCreate(
                ['section_key' => $section['section_key']],
                $section
            );
        }
    }
}
