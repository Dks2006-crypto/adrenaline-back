<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
                Select::make('membership_id')
                    ->relationship('membership', 'id'),
                TextInput::make('amount_cents')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('RUB'),
                TextInput::make('provider')
                    ->required(),
                TextInput::make('provider_payment_id'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
            ]);
    }
}
