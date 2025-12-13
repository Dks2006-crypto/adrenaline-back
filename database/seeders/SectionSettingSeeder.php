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
                'title' => 'Adrenaline Fitness  - Твой путь к идеальной форме начинается здесь.',
                'subtitle' => '',
                'description' => '• Удобное расположение в центре, рядом с достопримечательностями.

• Бесплатный Wi-Fi, свежий завтрак и круглосуточный сервис.

• Экологичные материалы и чистота на высшем уровне.',
                'button_text' => null,
                'button_link' => null,
                'image' => null, // Изображение будет загружено через админку
                'extra_data' => [
                    'background_overlay' => 'rgba(0,0,0,0.2)',
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
