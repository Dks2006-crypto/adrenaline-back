<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('name'),
                TextInput::make('last_name'),
                DatePicker::make('birth_date'),
                TextInput::make('gender'),
                TextInput::make('phone')
                    ->tel(),
                Select::make('role_id')
                    ->relationship('role', 'name')
                    ->required(),
                DateTimePicker::make('confirmed_at'),
                Textarea::make('metadata')
                    ->columnSpanFull(),
            ]);
    }
}
