<?php

namespace App\Filament\Admin\Resources\GalleryPosts\Pages;

use App\Filament\Admin\Resources\GalleryPosts\GalleryPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGalleryPost extends CreateRecord
{
    protected static string $resource = GalleryPostResource::class;
}
