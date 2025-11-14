<?php

namespace App\Filament\Admin\Resources\Attendances;

use App\Filament\Admin\Resources\Attendances\Pages\CreateAttendance;
use App\Filament\Admin\Resources\Attendances\Pages\EditAttendance;
use App\Filament\Admin\Resources\Attendances\Pages\ListAttendances;
use App\Filament\Admin\Resources\Attendances\Pages\ViewAttendance;
use App\Filament\Admin\Resources\Attendances\Schemas\AttendanceForm;
use App\Filament\Admin\Resources\Attendances\Tables\AttendancesTable;
use App\Models\Attendance;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
protected static ?string $model = Attendance::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationLabel = 'Посещаемость';
    protected static ?string $modelLabel = 'Посещение';

    public static function form(Schema $schema): Schema
    {
        return AttendanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking.user.email')
                    ->label('Клиент'),
                TextColumn::make('booking.class.service.title')
                    ->label('Занятие')
                    ->default('Персональная'),
                TextColumn::make('checked_in_at')
                    ->dateTime('d.m.Y H:i')
                    ->label('Заход'),
                TextColumn::make('checked_out_at')
                    ->dateTime('d.m.Y H:i')
                    ->label('Выход'),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->filters([
                TernaryFilter::make('checked_in_at')
                    ->label('Зарегистрирован'),
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
            'index' => ListAttendances::route('/'),
            'view' => ViewAttendance::route('/{record}'),
        ];
    }
}
