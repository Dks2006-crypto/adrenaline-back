<?php

namespace App\Filament\Resources\GalleryPosts\Pages;

use App\Filament\Resources\GalleryPosts\GalleryPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGalleryPost extends CreateRecord
{
    protected static string $resource = GalleryPostResource::class;
}
