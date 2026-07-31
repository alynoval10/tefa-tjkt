<?php

namespace App\Filament\Resources\Kas\Pages;

use App\Filament\Resources\Kas\KasResource;
use Filament\Resources\Pages\EditRecord;

class EditKas extends EditRecord
{
    protected static string $resource = KasResource::class;

    protected function getRedirectUrl(): string
    {
        return KasResource::getUrl('index');
    }
}