<?php

namespace App\Filament\Admin\Resources\Bookings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
                Select::make('class_id')
                    ->relationship('class', 'id'),
                Select::make('trainer_id')
                    ->relationship('trainer', 'id'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                DateTimePicker::make('cancelled_at'),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}
