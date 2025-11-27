<?php

namespace App\Filament\Admin\Resources\SectionSettings\Pages;

use App\Filament\Admin\Resources\SectionSettings\SectionSettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSectionSetting extends CreateRecord
{
    protected static string $resource = SectionSettingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
