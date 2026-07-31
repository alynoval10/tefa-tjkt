<?php

namespace App\Filament\Resources\Kas\Pages;

use App\Filament\Resources\Kas\KasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKas extends ListRecords
{
    protected static string $resource = KasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
