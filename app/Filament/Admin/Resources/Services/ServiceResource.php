<?php

namespace App\Filament\Admin\Resources\Services;

use App\Filament\Admin\Resources\Services\Pages\CreateService;
use App\Filament\Admin\Resources\Services\Pages\EditService;
use App\Filament\Admin\Resources\Services\Pages\ListServices;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'Тарифы';

    protected static ?string $modelLabel = 'тариф';

    protected static ?string $pluralModelLabel = 'Тарифы';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price_cents')
                    ->label('Цена')
                    ->money('RUB', divideBy: 100)
                    ->sortable(),

                TextColumn::make('base_benefits')
                    ->label('Преимущества')
                    ->formatStateUsing(fn ($state): string => is_array($state)
                        ? collect($state)->pluck('benefit')->implode(' • ')
                        : ''
                    )
                    ->limit(60)
                    ->tooltip(fn ($state) => is_array($state) ? collect($state)->pluck('benefit')->implode("\n") : null),

                BadgeColumn::make('type')
                    ->label('Тип')
                    ->colors([
                        'success' => 'monthly',
                        'warning' => 'single',
                        'info' => 'yearly',
                    ]),

                ToggleColumn::make('active')
                    ->label('Активен'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
