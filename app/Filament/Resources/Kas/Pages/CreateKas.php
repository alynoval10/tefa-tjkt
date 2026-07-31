<?php

namespace App\Filament\Resources\Kas\Pages;

use App\Actions\Kas\GenerateNoBukti;
use App\Filament\Resources\Kas\KasResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKas extends CreateRecord
{
    protected static string $resource = KasResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        $nomor = app(GenerateNoBukti::class)->execute(
            $data['category_id'],
            $data['tanggal']
        );

        return array_merge($data, $nomor);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}