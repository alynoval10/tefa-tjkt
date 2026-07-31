<?php

namespace App\Filament\Resources\Kas\Pages;

use App\Filament\Resources\Kas\KasResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKas extends ViewRecord
{
    protected static string $resource = KasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
