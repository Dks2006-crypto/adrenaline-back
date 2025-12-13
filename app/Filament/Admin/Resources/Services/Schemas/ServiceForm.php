<?php

namespace App\Filament\Admin\Resources\Services\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Название')
                    ->required(),

                Textarea::make('description')
                    ->label('Описание')
                    ->columnSpanFull(),

                Repeater::make('base_benefits')
                    ->label('Базовые преимущества')
                    ->schema([
                        TextInput::make('benefit')
                            ->label('Преимущество')
                            ->required(),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['benefit'] ?? null)
                    ->defaultItems(3)
                    ->reorderable()
                    ->addActionLabel('Добавить преимущество'),

                TextInput::make('duration_days')
                    ->label('Длительность (дни)')
                    ->numeric()
                    ->required(),

                TextInput::make('visits_limit')
                    ->label('Лимит посещений')
                    ->numeric()
                    ->nullable(),

                TextInput::make('price_cents')
                    ->label('Цена (в копейках)')
                    ->numeric()
                    ->required()
                    ->helperText('Пример: 490000 = 4900.00 ₽'),

                Toggle::make('active')
                    ->label('Активен')
                    ->default(true),

                Select::make('type')
                    ->label('Тип тарифа')
                    ->options([
                        'single' => 'Разовый',
                        'monthly' => 'Месячный',
                        'yearly' => 'Годовой',
                    ])
                    ->default('monthly')
                    ->required(),
            ]);
    }
}
