<?php

namespace App\Filament\Pages;

use App\Services\BukuKasService;
use Filament\Pages\Page;

class LaporanBukuKas extends Page
{
    protected static ?string $navigationLabel = 'Laporan Buku Kas';

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.laporan-buku-kas';

    /**
     * Filter
     */
    public ?string $tanggalAwal = null;

    public ?string $tanggalAkhir = null;

    /**
     * Data laporan
     */
    public array $summary = [];

    public array $laporan = [];

    public function mount(): void
    {
        $this->tanggalAwal = now()->startOfMonth()->toDateString();
        $this->tanggalAkhir = now()->toDateString();

        $this->loadData();
    }

    public function loadData(): void
    {
        $service = app(BukuKasService::class);

        $this->summary = $service->summary(
            $this->tanggalAwal,
            $this->tanggalAkhir
        );

        $this->laporan = $service
            ->laporan(
                $this->tanggalAwal,
                $this->tanggalAkhir
            )
            ->toArray();
    }
}