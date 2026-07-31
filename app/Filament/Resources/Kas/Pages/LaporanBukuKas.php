<?php

namespace App\Filament\Resources\Kas\Pages;

use App\Filament\Resources\Kas\KasResource;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class LaporanBukuKas extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = KasResource::class;

    protected string $view = 'filament.pages.laporan-buku-kas';

    protected static ?string $title = 'Laporan Buku Kas';

    public ?string $tanggalAwal = null;

    public ?string $tanggalAkhir = null;

    public function mount(): void
    {
        $this->tanggalAwal = now()->startOfMonth()->toDateString();
        $this->tanggalAkhir = now()->toDateString();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Filter Laporan')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('tanggalAwal')
                            ->label('Tanggal Awal')
                            ->live(),

                        Forms\Components\DatePicker::make('tanggalAkhir')
                            ->label('Tanggal Akhir')
                            ->live(),
                    ]),
            ]);
    }

    public static function getPages(): array
{
    return [
        'index' => ListKas::route('/'),
        'create' => CreateKas::route('/create'),
        'view' => ViewKas::route('/{record}'),
        'edit' => EditKas::route('/{record}/edit'),
    ];
}
}