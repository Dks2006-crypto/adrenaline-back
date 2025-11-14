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
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('duration_days')
                    ->required()
                    ->numeric(),
                TextInput::make('visits_limit')
                    ->numeric(),
                TextInput::make('price_cents')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('RUB'),
                Select::make('branch_id')
                    ->relationship('branch', 'name'),
                Toggle::make('active')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('monthly'),
            ]);
    }
}
