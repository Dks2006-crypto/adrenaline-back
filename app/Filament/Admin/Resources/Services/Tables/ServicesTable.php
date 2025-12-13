<?php

namespace App\Filament\Admin\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
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
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
