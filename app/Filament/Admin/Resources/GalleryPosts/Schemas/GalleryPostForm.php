<?php

namespace App\Filament\Admin\Resources\GalleryPosts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GalleryPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->nullable(),
                TextInput::make('subtitle')->nullable(),
                FileUpload::make('image')
                    ->directory('gallery')
                    ->disk('public')
                    ->visibility('public')
                    ->image()
                    ->required(),
                Toggle::make('active')->default(true),
            ]);
    }
}
