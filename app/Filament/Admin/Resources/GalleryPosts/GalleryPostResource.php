<?php

namespace App\Filament\Admin\Resources\GalleryPosts;

use App\Filament\Admin\Resources\GalleryPosts\Pages\CreateGalleryPost;
use App\Filament\Admin\Resources\GalleryPosts\Pages\EditGalleryPost;
use App\Filament\Admin\Resources\GalleryPosts\Pages\ListGalleryPosts;
use App\Filament\Admin\Resources\GalleryPosts\Schemas\GalleryPostForm;
use App\Filament\Admin\Resources\GalleryPosts\Tables\GalleryPostsTable;
use App\Models\GalleryPost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GalleryPostResource extends Resource
{
    protected static ?string $model = GalleryPost::class;

    protected static ?string $navigationLabel = 'Gallery секция';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $modelLabel = 'Gallery секция';

    protected static ?string $pluralModelLabel = 'Gallery секция';

    protected static string|UnitEnum|null $navigationGroup = 'Контент';

    public static function form(Schema $schema): Schema
    {
        return GalleryPostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GalleryPostsTable::configure($table);
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
            'index' => ListGalleryPosts::route('/'),
            'create' => CreateGalleryPost::route('/create'),
            'edit' => EditGalleryPost::route('/{record}/edit'),
        ];
    }
}
