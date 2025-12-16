<?php

namespace App\Filament\Resources\GalleryPosts\Pages;

use App\Filament\Resources\GalleryPosts\GalleryPostResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGalleryPost extends EditRecord
{
    protected static string $resource = GalleryPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
