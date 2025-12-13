<?php

namespace App\Filament\Admin\Resources\GalleryPosts\Pages;

use App\Filament\Admin\Resources\GalleryPosts\GalleryPostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGalleryPosts extends ListRecords
{
    protected static string $resource = GalleryPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
