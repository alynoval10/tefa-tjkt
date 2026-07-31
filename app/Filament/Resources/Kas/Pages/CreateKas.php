<?php

namespace App\Filament\Resources\Kas\Pages;

use App\Filament\Resources\Kas\KasResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateKas extends CreateRecord
{
    protected static string $resource = KasResource::class;

   protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = auth()->id();

    $nomor = \App\Models\Kas::generateNoBukti(
        $data['category_id'],
        $data['tanggal']
    );

    $data['nomor_urut'] = $nomor['nomor_urut'];
    $data['no_bukti'] = $nomor['no_bukti'];

    return $data;
}

    protected function getRedirectUrl(): string
    {
        return KasResource::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Berhasil')
            ->body('Data kas berhasil disimpan.');
    }
    protected function generateNoBukti(array $data): string
{
    $category = \App\Models\Category::find($data['category_id']);

    $prefix = $category->type === 'income' ? 'KM' : 'KK';

    $date = \Carbon\Carbon::parse($data['tanggal']);

    $periode = $date->format('Ym');

    $last = \App\Models\Kas::where('no_bukti', 'like', "{$prefix}-{$periode}-%")
        ->orderByDesc('no_bukti')
        ->first();

    $nomor = 1;

        if ($last) {
            $lastNumber = (int) substr($last->no_bukti, -6);
            $nomor = $lastNumber + 1;
        }

        return sprintf(
            '%s-%s-%06d',
            $prefix,
            $periode,
            $nomor
        );
}
}