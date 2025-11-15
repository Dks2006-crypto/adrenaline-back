<?php

namespace App\Filament\Admin\Resources\Bookings;

use App\Filament\Admin\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Admin\Resources\Bookings\Pages\EditBooking;
use App\Filament\Admin\Resources\Bookings\Pages\ListBookings;
use App\Filament\Admin\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Admin\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BookingResource extends Resource
{
protected static ?string $model = Booking::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Бронирования';

    public static function getRecordTitle(?Model $record): ?string
{
    if (!$record) {
        return null;
    }

    return match (true) {

        $record instanceof Booking =>
            ($record->user?->name ?? 'Клиент') . ' → ' .
            ($record->class?->service?->title ?? 'Персональная тренировка'),

        default => $record->getKey(),
    };
}

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'email')
                    ->required(),
                Select::make('class_id')
                    ->relationship('class.service', 'title'),
                Select::make('trainer_id')
                    ->relationship('trainer.user', 'name'),
                Select::make('status')
                    ->options([
                        'pending' => 'Ожидает',
                        'confirmed' => 'Подтверждено',
                        'cancelled' => 'Отменено',
                        'completed' => 'Завершено',
                    ]),
                Textarea::make('note'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email'),
                TextColumn::make('class.service.title')
                    ->label('Занятие'),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger' => 'cancelled',
                    ]),
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
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }
}
