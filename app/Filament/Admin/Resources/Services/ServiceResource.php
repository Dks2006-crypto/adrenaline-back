<?php

namespace App\Filament\Admin\Resources\Services;

use App\Filament\Admin\Resources\Services\Pages\CreateService;
use App\Filament\Admin\Resources\Services\Pages\EditService;
use App\Filament\Admin\Resources\Services\Pages\ListServices;
use App\Filament\Admin\Resources\Services\Schemas\ServiceForm;
use App\Filament\Admin\Resources\Services\Tables\ServicesTable;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
protected static ?string $model = Service::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Тарифы';
    protected static ?string $titleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description'),
                TextInput::make('duration_days')
                    ->numeric()
                    ->required(),
                TextInput::make('visits_limit')
                    ->numeric()
                    ->nullable(),
                TextInput::make('price_cents')
                    ->label('Цена (в копейках)')
                    ->numeric()
                    ->required()
                    ->helperText('490000 = 4900.00 ₽'),
                Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->required(),
                Toggle::make('active')
                    ->default(true),
                Select::make('type')
                    ->options([
                        'single' => 'Разовый',
                        'monthly' => 'Месячный',
                        'yearly' => 'Годовой',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('price_cents')
                    ->money('RUB', 100)
                    ->sortable(),
                TextColumn::make('branch.name'),
                BadgeColumn::make('type')
                    ->colors([
                        'success' => 'monthly',
                        'warning' => 'single',
                        'info' => 'yearly',
                    ]),
                ToggleColumn::make('active'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
