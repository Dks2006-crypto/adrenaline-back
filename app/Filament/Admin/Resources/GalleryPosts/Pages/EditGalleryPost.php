<?php

namespace App\Filament\Admin\Resources\GalleryPosts\Pages;

use App\Filament\Admin\Resources\GalleryPosts\GalleryPostResource;
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
